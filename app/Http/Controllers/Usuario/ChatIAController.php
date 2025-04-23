<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\WorkoutProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ChatIAController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $messages = ChatMessage::where('user_id', $user->id)
            ->orderBy('created_at')
            ->get();

        if ($messages->isEmpty()) {
            ChatMessage::create([
                'user_id' => $user->id,
                'message' => "Olá, {$user->name}! 👋\n\nSou a **Nexy**, sua assistente virtual aqui no SynapseFit. Estou aqui pra te ajudar com sua dieta, treinos, hidratação e muito mais. Sempre que precisar, é só me chamar! 💪",
                'is_bot'  => true,
                'tipo'    => 'ia',
                'name'    => 'Nexy',
                'avatar'  => 'img/nexy.png',
            ]);

            $messages = ChatMessage::where('user_id', $user->id)
                ->orderBy('created_at')
                ->get();
        }

        return view('usuario.chat.index', compact('messages'));
    }

    public function enviar(Request $request)
    {
        $user = Auth::user();

        $userMessage = ChatMessage::create([
            'user_id' => $user->id,
            'message' => $request->input('message'),
            'is_bot'  => false,
            'tipo'    => 'usuario',
        ]);

        $resposta = $this->gerarRespostaDaIA($userMessage->message);

        ChatMessage::create([
            'user_id' => $user->id,
            'message' => $resposta,
            'is_bot'  => true,
            'tipo'    => 'ia',
            'name'    => 'Nexy',
            'avatar'  => 'img/nexy.png',
        ]);

        return redirect()->route('chat.index');
    }

    private function gerarRespostaDaIA($pergunta)
    {
        $user           = Auth::user();
        $bio            = $user->bioimpedance()->latest()->first();
        $dieta          = $user->dieta;
        $alimentacao    = $user->alimentacoes()->whereDate('created_at', today())->get();
        $aguaConsumida  = $user->aguaConsumida()->whereDate('registrado_em', today())->sum('quantidade');
        $suplementos    = $user->suplementos ?? [];
        $pergunta       = strtolower(trim($pergunta));

        $palavrasPermitidas = [
            'alimentação'    => ['alimentação', 'refeição', 'comida', 'comi', 'alimento'],
            'água'           => ['água', 'hidratação', 'beber', 'bebi', 'líquido'],
            'treino'         => ['treino', 'exercício', 'atividade', 'ficha'],
            'dieta'          => ['dieta', 'nutrição', 'macros', 'calorias', 'cardápio'],
            'bioimpedância'  => ['bioimpedância', 'imc', 'massa magra', 'gordura', 'peso'],
            'motivação'      => ['motivação', 'parado', 'preguiça', 'desanimado'],
            'meta'           => ['meta', 'objetivo', 'progresso', 'resultado'],
        ];

        foreach ($palavrasPermitidas as $tipo => $chaves) {
            if ($this->verificarPalavraChave($pergunta, $chaves)) {
                switch ($tipo) {
                    case 'alimentação':
                        return $this->respostaAlimentacao($user, $dieta, $alimentacao, $aguaConsumida, $suplementos);
                    case 'água':
                        return $this->respostaAgua($aguaConsumida, $dieta);
                    case 'treino':
                        return $this->respostaTreino($user);
                    case 'dieta':
                        return $this->respostaDieta($dieta, $alimentacao, $aguaConsumida);
                    case 'bioimpedância':
                        return $this->respostaBioimpedancia($bio);
                    case 'motivação':
                        return "💪 Ei {$user->name}, lembre-se por que começou. Você está indo bem e cada passo conta. Que tal um treino leve hoje só pra manter o ritmo?";
                    case 'meta':
                        return $this->respostaMeta($user, $bio, $dieta);
                }
            }
        }

        return "🤖 Ainda estou aprendendo! Tente perguntas como:\n" .
            "- Qual é minha dieta hoje?\n" .
            "- Já bati minha meta de proteínas?\n" .
            "- Último treino\n" .
            "- Meus dados de bioimpedância\n" .
            "- Quanto de água bebi hoje?\n" .
            "- Estou perto da minha meta?";
    }

    private function verificarPalavraChave($pergunta, $palavrasChave)
    {
        foreach ($palavrasChave as $palavra) {
            if (str_contains($pergunta, $palavra)) {
                return true;
            }
        }
        return false;
    }

    private function respostaAlimentacao($user, $dieta, $alimentacao, $aguaConsumida, $suplementos)
    {
        if (!$dieta) return "❗ Você ainda não possui uma dieta cadastrada.";

        $totais = [
            'calorias' => 0,
            'proteinas' => 0,
            'carboidratos' => 0,
            'gorduras' => 0,
            'fibras' => 0,
            'sodio' => 0
        ];

        $resposta = "🍎 **Dieta para _{$user->objetivo}_**\n";
        $resposta .= "- Calorias: {$dieta->calorias} kcal\n";
        $resposta .= "- Proteínas: {$dieta->proteinas}g\n";
        $resposta .= "- Carboidratos: {$dieta->carboidratos}g\n";
        $resposta .= "- Gorduras: {$dieta->gorduras}g\n";
        $resposta .= "- Fibras: {$dieta->fibras}g\n";
        $resposta .= "- Sódio: {$dieta->sodio} mg\n";
        $resposta .= "- Água: {$dieta->agua} ml\n\n";

        if ($alimentacao->count()) {
            $resposta .= "📌 **Hoje você comeu:**\n";
            foreach ($alimentacao as $refeicao) {
                $resposta .= "- {$refeicao->tipo}: {$refeicao->nome} ({$refeicao->calorias} kcal)\n";
                foreach (array_keys($totais) as $macro) {
                    $totais[$macro] += $refeicao->$macro;
                }
            }

            $resposta .= "\n📊 **Total consumido:**\n";
            foreach ($totais as $macro => $valor) {
                $unidade = $macro === 'sodio' ? 'mg' : ($macro === 'calorias' ? 'kcal' : 'g');
                $resposta .= "- " . ucfirst($macro) . ": {$valor} {$unidade}\n";
            }

            $resposta .= "\n🎯 **Meta restante:**\n";
            foreach (['calorias', 'proteinas', 'carboidratos', 'gorduras'] as $macro) {
                $restante = max(0, $dieta->$macro - $totais[$macro]);
                $unidade = $macro === 'calorias' ? 'kcal' : 'g';
                $resposta .= "- " . ucfirst($macro) . ": {$restante} {$unidade}\n";
            }

            if ($totais['sodio'] > $dieta->sodio) {
                $resposta .= "\n⚠️ Atenção: Você ultrapassou o sódio recomendado.\n";
            }
        } else {
            $resposta .= "⚠️ Nenhum alimento registrado hoje.\n";
        }

        return $resposta;
    }

    private function respostaTreino($user)
    {
        $ultimoTreino = WorkoutProgress::where('user_id', $user->id)
            ->orderByDesc('data_treino')
            ->first();

        if (!$ultimoTreino) {
            return "🏋️ Você ainda não iniciou nenhum treino.";
        }

        $data = Carbon::parse($ultimoTreino->data_treino)->format('d/m/Y');
        $dataBusca = Carbon::parse($ultimoTreino->data_treino)->toDateString();
        $type = $ultimoTreino->type;

        $totalSeries = WorkoutProgress::where('user_id', $user->id)
            ->whereDate('data_treino', $dataBusca)
            ->where('type', $type)
            ->sum('series_completed');

        if ($totalSeries >= 30) {
            return "✅ Treino do dia {$data} (Ficha {$type}) concluído com sucesso!";
        } else {
            return "⚠️ Último treino em {$data}, ficha {$type}.\nVocê completou {$totalSeries}/30 séries.";
        }
    }

    private function respostaBioimpedancia($bio)
    {
        $user = Auth::user();

        if (!$bio) return "📉 Nenhum registro de bioimpedância encontrado.";

        return "📊 Bioimpedância em {$bio->data_medicao}:\n" .
            "- Peso: {$user->weight} kg\n" .
            "- IMC: {$bio->imc}\n" .
            "- Massa magra: {$bio->massa_magra} kg\n" .
            "- Gordura: {$bio->massa_gordura} kg\n";
    }

    private function respostaAgua($aguaConsumida, $dieta)
    {
        return "💧 Você bebeu {$aguaConsumida} ml de água hoje. " .
            "Meta diária: {$dieta->agua} ml. " .
            ($aguaConsumida < $dieta->agua ? "🔔 Beba mais água!" : "✅ Parabéns pela hidratação!");
    }

    private function respostaDieta($dieta, $alimentacao, $aguaConsumida)
    {
        if (!$dieta) return "📋 Nenhuma dieta cadastrada no momento.";

        return "🍏 Dieta diária:\n" .
            "- Calorias: {$dieta->calorias} kcal\n" .
            "- Proteínas: {$dieta->proteinas}g\n" .
            "- Carboidratos: {$dieta->carboidratos}g\n" .
            "- Gorduras: {$dieta->gorduras}g\n" .
            "- Fibras: {$dieta->fibras}g\n" .
            "- Sódio: {$dieta->sodio}mg\n" .
            "- Água: {$dieta->agua} ml\n\n" .
            "💡 Lembre-se de registrar o que comeu e a água consumida para um acompanhamento mais preciso!";
    }

    private function respostaMeta($user, $bio, $dieta)
    {
        if (!$bio || !$dieta) {
            return "⚠️ Ainda não tenho informações completas para avaliar seu progresso. Registre sua bioimpedância e siga a dieta para começarmos!";
        }

        $imc = number_format($bio->imc, 1);
        $peso = $user->weight;
        $massaMagra = $bio->massa_magra;
        $gordura = $bio->massa_gordura;

        $mensagem = "📈 Progresso atual:\n";
        $mensagem .= "- Peso: {$peso} kg\n";
        $mensagem .= "- IMC: {$imc}\n";
        $mensagem .= "- Massa magra: {$massaMagra} kg\n";
        $mensagem .= "- Gordura: {$gordura} kg\n\n";

        $mensagem .= "🎯 Objetivo: _{$user->objetivo}_\n";

        if ($user->objetivo === 'emagrecimento' && $imc > 25) {
            $mensagem .= "Você está no caminho certo! Continue focando em reduzir a gordura corporal e manter a massa magra. 🚶‍♂️🥗";
        } elseif ($user->objetivo === 'hipertrofia' && $massaMagra < ($peso * 0.75)) {
            $mensagem .= "Ainda dá pra ganhar mais massa magra! Capriche nas proteínas e mantenha os treinos consistentes. 💪";
        } elseif ($user->objetivo === 'resistência') {
            $mensagem .= "Ótimo! Continue equilibrando treinos de força e cardio para manter e melhorar sua resistência. 🏃‍♀️🔥";
        } else {
            $mensagem .= "Seu progresso está alinhado com o objetivo. Parabéns, continue assim! 🎉";
        }

        return $mensagem;
    }
}