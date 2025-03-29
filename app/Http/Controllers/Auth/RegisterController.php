<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Exercise;
use App\Models\Workout;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'height' => ['required', 'numeric', 'min:0'],
            'weight' => ['required', 'numeric', 'min:0'],
            'sex' => ['required', 'in:male,female'],
            'age' => ['required', 'numeric', 'min:18'],
            'objetivo' => ['required', 'in:hipertrofia,emagrecimento,resistencia'], // Objetivo do aluno
        ]);
    }

    protected function create(array $data)
    {
        // Dados do usuário
        $height = $data['height'];
        $weight = $data['weight'];
        $age = $data['age'];
        $sex = $data['sex'];

        // Calculando o IMC
        $imc = $weight / ($height * $height);

        // Calculando outros dados de bioimpedância
        $massaMagra = $this->calcularMassaMagra($weight, $height, $sex);
        $percentualGordura = $this->calcularPercentualGordura($imc, $age, $sex);
        $massaGordura = $weight * ($percentualGordura / 100);
        $aguaCorporal = $this->calcularAguaCorporal($massaMagra);
        $visceralFat = $this->calcularGorduraVisceral($weight, $height, $sex);
        $pesoIdealInferior = 22 * ($height * $height) - 5;
        $pesoIdealSuperior = 22 * ($height * $height) + 5;

        // Calculando a recomendação de calorias diárias
        $calorias = $this->calcularCalorias($weight, $height, $age, $sex);

        // Classificação do IMC
        $imcClassificacao = $this->classificarIMC($imc);

        // Calculando a Idade Corporal
        $idadeCorporal = $this->calcularIdadeCorporal($age, $percentualGordura, $sex);

        // Calculando o Metabolismo Basal (BMR)
        $bmr = $this->calcularBMR($weight, $height, $age, $sex);

        // Criando o usuário com as informações adicionais
        $user = User::create([
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'height' => $height,
            'weight' => $weight,
            'imc' => $imc,
            'peso_ideal_inferior' => $pesoIdealInferior,
            'peso_ideal_superior' => $pesoIdealSuperior,
            'calorias_recomendadas' => $calorias,
            'imc_classificacao' => $imcClassificacao,
            'massa_magra' => $massaMagra,
            'percentual_gordura' => $percentualGordura,
            'massa_gordura' => $massaGordura,
            'agua_corporal' => $aguaCorporal,
            'visceral_fat' => $visceralFat,
            'idade_corporal' => $idadeCorporal,
            'bmr' => $bmr,
            'sex' => $sex,
            'age' => $age,
            'objetivo' => $data['objetivo'], // Objetivo adicionado
        ]);

        // Gerar a dieta para o usuário
        $dieta = $this->gerarDieta($user);

        // Salvar a dieta no banco de dados ou utilizá-la conforme necessário
        // Exemplo de como você pode salvar os dados da dieta:
        $user->dieta()->create([
            'calorias' => $dieta['calorias'],
            'proteinas' => $dieta['proteinas'],
            'carboidratos' => $dieta['carboidratos'],
            'gorduras' => $dieta['gorduras'],
            'suplementos' => implode(', ', $dieta['suplementos']),
            'agua' => $dieta['agua'],
        ]);

        // Obtenha os exercícios para os grupos musculares superiores e inferiores
        $upper_body_exercises = Exercise::whereIn('muscle_group', ['Peito', 'Costas', 'Ombros', 'Bíceps', 'Tríceps', 'Abdômen'])->get();
        $lower_body_exercises = Exercise::whereIn('muscle_group', ['Pernas', 'Glúteos'])->get();

        // Criar as fichas de treino para o usuário
        $this->createWorkout($user, 'A', $upper_body_exercises->random(10)); // Ficha A
        $this->createWorkout($user, 'B', $upper_body_exercises->random(10)); // Ficha B
        $this->createWorkout($user, 'C', $lower_body_exercises->random(10));  // Ficha C

        return $user;
    }

    // Função para calcular a dieta com base no objetivo e nas necessidades do aluno
    private function gerarDieta($user)
    {
        // Obter o IMC e o objetivo do aluno
        $imc = $user->imc;
        $objetivo = $user->objetivo; // 'hipertrofia', 'emagrecimento', 'resistencia'

        // Ingestão calórica com base no objetivo
        $calorias = $this->calcularCalorias($user->weight, $user->height, $user->age, $user->sex);

        if ($objetivo == 'hipertrofia') {
            $calorias += 500; // Aumenta 500 calorias para hipertrofia
        } elseif ($objetivo == 'emagrecimento') {
            $calorias -= 500; // Diminui 500 calorias para emagrecimento
        }

        // Calcular a distribuição dos macronutrientes com base nas calorias
        // Aproximações para macronutrientes: 1g de proteína = 4 calorias, 1g de carboidrato = 4 calorias, 1g de gordura = 9 calorias
        $proteinas = round($calorias * 0.3 / 4); // 30% das calorias para proteínas
        $carboidratos = round($calorias * 0.4 / 4); // 40% das calorias para carboidratos
        $gorduras = round($calorias * 0.3 / 9); // 30% das calorias para gorduras

        // Suplementos recomendados com base no objetivo
        $suplementos = [];
        if ($objetivo == 'hipertrofia') {
            $suplementos = ['Whey Protein', 'Creatina'];
        } elseif ($objetivo == 'emagrecimento') {
            $suplementos = ['Termogênico', 'Whey Protein'];
        } elseif ($objetivo == 'resistencia') {
            $suplementos = ['BCAA', 'Whey Protein'];
        }

        // Ingestão de água recomendada com base na massa magra
        $agua = round($user->agua_corporal * 0.75, 2); // 75% da água corporal é recomendada para ingestão

        // Criando a dieta para o usuário
        return [
            'calorias' => $calorias,
            'proteinas' => $proteinas,
            'carboidratos' => $carboidratos,
            'gorduras' => $gorduras,
            'suplementos' => $suplementos,
            'agua' => $agua
        ];
    }

    // Função para calcular a Massa Magra
    private function calcularMassaMagra($weight, $height, $sex)
    {
        if ($sex == 'male') {
            return (0.407 * $weight) + (0.267 * $height) - 19.2;
        } else {
            return (0.252 * $weight) + (0.473 * $height) - 48.3;
        }
    }

    // Função para calcular o Percentual de Gordura
    private function calcularPercentualGordura($imc, $age, $sex)
    {
        if ($sex == 'male') {
            return (1.20 * $imc) + (0.23 * $age) - 16.2;
        } else {
            return (1.20 * $imc) + (0.23 * $age) - 5.4;
        }
    }

    // Função para calcular a Água Corporal (estimativa)
    private function calcularAguaCorporal($massaMagra)
    {
        return round($massaMagra * 0.70, 2); // Aproximadamente 70% da massa magra é água
    }

    // Função para calcular a Gordura Visceral (estimativa)
    private function calcularGorduraVisceral($weight, $height, $sex)
    {
        if ($sex == 'male') {
            return round(($weight * 0.10), 2); // Aproximadamente 10% da gordura corporal total é visceral para homens
        } else {
            return round(($weight * 0.07), 2); // Aproximadamente 7% da gordura corporal total é visceral para mulheres
        }
    }

    // Função para calcular a Idade Corporal
    private function calcularIdadeCorporal($age, $percentualGordura, $sex)
    {
        if ($sex == 'male') {
            return round($age - ($percentualGordura / 5));
        } else {
            return round($age - ($percentualGordura / 4));
        }
    }

    // Função para calcular o Metabolismo Basal (BMR)
    private function calcularBMR($weight, $height, $age, $sex)
    {
        if ($sex == 'male') {
            return 88.362 + (13.397 * $weight) + (4.799 * $height * 100) - (5.677 * $age);
        } else {
            return 447.593 + (9.247 * $weight) + (3.098 * $height * 100) - (4.330 * $age);
        }
    }

    // Função para calcular as calorias recomendadas
    private function calcularCalorias($weight, $height, $age, $sex)
    {
        if ($sex == 'male') {
            $calorias = 10 * $weight + 6.25 * $height * 100 - 5 * $age + 5;
        } else {
            $calorias = 10 * $weight + 6.25 * $height * 100 - 5 * $age - 161;
        }
        return round($calorias * 1.55); // Atividade moderada
    }

    // Função para classificar o IMC
    private function classificarIMC($imc)
    {
        if ($imc < 18.5) {
            return 'Abaixo do peso';
        } elseif ($imc >= 18.5 && $imc < 24.9) {
            return 'Peso normal';
        } elseif ($imc >= 25 && $imc < 29.9) {
            return 'Sobrepeso';
        } else {
            return 'Obesidade';
        }
    }

    // Função para criar o treino do usuário
    private function createWorkout($user, $type, $exercises)
    {
        foreach ($exercises as $exercise) {
            Workout::create([
                'user_id' => $user->id,
                'type' => $type,
                'exercise_id' => $exercise->id,
                'series' => 3, // Séries fixas
                'repeticoes' => 12, // Repetições fixas
                'descanso' => 60, // Descanso fixo
                'carga' => null, // Carga inicial
            ]);
        }
    }
}
