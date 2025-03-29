<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Workout;
use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Exemplo de como você pode obter os dados (substitua pelos dados reais)
        $user = auth()->user(); // Supondo que você tenha um usuário autenticado

        // Aqui você precisa garantir que esses dados venham do banco ou de onde for necessário
        $imc = $user->imc; // ou uma lógica para calcular o IMC
        $percentualGordura = $user->percentual_gordura; // idem para gordura
        $caloriasRecomendadas = $user->calorias_recomendadas;
        $idadeCorporal = $user->idade_corporal;
        $pesoIdealInferior = $user->peso_ideal_inferior;
        $pesoIdealSuperior = $user->peso_ideal_superior;
        $massaMagra = $user->massa_magra;
        $massaGordura = $user->massa_gordura;
        $aguaCorporal = $user->agua_corporal;
        $visceralFat = $user->visceral_fat;
        $bmr = $user->bmr; // Taxa de Metabolismo Basal

        // Passando todos os dados para a view
        return view('home', compact(
            'imc',
            'percentualGordura',
            'caloriasRecomendadas',
            'idadeCorporal',
            'pesoIdealInferior',
            'pesoIdealSuperior',
            'massaMagra',
            'massaGordura',
            'aguaCorporal',
            'visceralFat',
            'bmr'
        ));
    }
}
