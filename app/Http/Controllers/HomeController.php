<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Bioimpedance;
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

        $bioimpedance = $user->bioimpedance;

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
            $grauObesidade = $bioimpedance->grau_obesidade;
            $impedanciaSegmentos = $bioimpedance->impedancia_segmentos;
        } else {
            $imc = $percentualGordura = $pesoIdealInferior = $pesoIdealSuperior = $massaMagra = $massaGordura = $aguaCorporal
            = $visceralFat = $idadeCorporal = $massaMuscular = $massaOssea = $bmr = null;
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
        ));
    }
}
