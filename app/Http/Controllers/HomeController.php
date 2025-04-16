<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Bioimpedance;
use App\Models\Hidratacao;
use App\Models\Dieta;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        $users = User::count();
        $bioimpedancias = Bioimpedance::count();
        $dietas = Dieta::count();

        $totalMl = Hidratacao::sum('quantidade');
        $totalLitros = round($totalMl / 1000, 2);

        $widget = [
            'users' => $users,
            'bioimpedancias' => $bioimpedancias,
            'dietas' => $dietas,
            'aguaLitros' => $totalLitros,
        ];

        $assinaturaAtiva = $user->subscriptions()
        ->where('is_active', true)
        ->latest('end_date')
        ->first();

        $diasRestantes = null;

        if ($assinaturaAtiva) {
            $hoje = Carbon::now()->startOfDay();
            $fim = Carbon::parse($assinaturaAtiva->end_date)->startOfDay();

            $diasRestantes = $hoje->diffInDays($fim, false);
        }

        $bioimpedance = Bioimpedance::where('user_id', $user->id)
            ->orderByDesc('data_medicao')
            ->first();

        if ($bioimpedance) {
            $imc = $bioimpedance->imc;
            $percentualGordura = $bioimpedance->percentual_gordura;
            $pesoIdealInferior = $bioimpedance->peso_ideal_inferior;
            $pesoIdealSuperior = $bioimpedance->peso_ideal_superior;
            $massaMagra = $bioimpedance->massa_magra;
            $massaGordura = $bioimpedance->massa_gordura;
            $aguaCorporal = $bioimpedance->agua_corporal;
            $visceralFat = $bioimpedance->visceral_fat;
            $idadeCorporal = $bioimpedance->idade_corporal;
            $bmr = $bioimpedance->bmr;
            $massaMuscular = $bioimpedance->massa_muscular;
            $massaOssea = $bioimpedance->massa_ossea;
            $grauObesidade = $bioimpedance->grau_obesidade ?? 'Não disponível';
            $impedanciaSegmentos = $bioimpedance->impedancia_segmentos ?? 'Não disponível';
        } else {
            $imc = $percentualGordura = $pesoIdealInferior = $pesoIdealSuperior = $massaMagra = $massaGordura =
            $aguaCorporal = $visceralFat = $idadeCorporal = $bmr = $massaMuscular = $massaOssea = null;

            $grauObesidade = 'Não disponível';
            $impedanciaSegmentos = 'Não disponível';
        }

        return view('home', compact(
            'imc',
            'percentualGordura',
            'pesoIdealInferior',
            'pesoIdealSuperior',
            'massaMagra',
            'massaGordura',
            'aguaCorporal',
            'visceralFat',
            'idadeCorporal',
            'bmr',
            'massaMuscular',
            'massaOssea',
            'grauObesidade',
            'impedanciaSegmentos',
            'widget',
            'diasRestantes', 'assinaturaAtiva'
        ));
    }
}
