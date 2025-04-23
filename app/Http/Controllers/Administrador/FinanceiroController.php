<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FinanceiroController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : Carbon::now()->startOfMonth();
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : Carbon::now()->endOfMonth();

        $planId = $request->input('plan_id');
        $paymentMethod = $request->input('payment_method');

        $assinaturasQuery = UserSubscription::with(['user', 'plan'])
            ->whereBetween('start_date', [$startDate, $endDate]);

        if ($planId) {
            $assinaturasQuery->where('plan_id', $planId);
        }

        if ($paymentMethod) {
            $assinaturasQuery->where('payment_method', $paymentMethod);
        }

        $assinaturas = $assinaturasQuery->paginate(10);

        $totalArrecadado = $assinaturas->sum(function ($assinatura) {
            return $assinatura->plan->price;
        });

        $ativos = UserSubscription::where('is_active', true)
            ->whereBetween('start_date', [$startDate, $endDate])
            ->count();

        $inativos = UserSubscription::where('is_active', false)
            ->whereBetween('start_date', [$startDate, $endDate])
            ->count();

        $totalAssinaturas = $assinaturas->count();

        $resumoPorPlano = $assinaturas->groupBy('plan_id')->map(function ($group) {
            return $group->sum(function ($assinatura) {
                return $assinatura->plan->price;
            });
        });

        $plans = Plan::all();
        $paymentMethods = UserSubscription::distinct()->pluck('payment_method');

        return view('administrador.financeiro.index', compact(
            'assinaturas',
            'totalArrecadado',
            'ativos',
            'inativos',
            'totalAssinaturas',
            'resumoPorPlano',
            'startDate',
            'endDate',
            'planId',
            'plans',
            'paymentMethods',
            'paymentMethod'
        ));
    }
}
