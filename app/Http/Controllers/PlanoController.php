<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Subscription;
use App\Services\MercadoPagoService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PlanoController extends Controller
{
    public function index()
    {
        $plans = Plan::all();
        return view('planos.index', compact('plans'));
    }

    public function confirmar(Plan $plan)
    {
        return view('planos.confirmar', ['plano' => $plan]);
    }

    public function assinar(Request $request, Plan $plan, MercadoPagoService $mpService)
    {
        $user = Auth::user();
        Log::debug("[PlanoController] Usuário {$user->id} iniciou assinatura do plano '{$plan->name}'.");

        $validator = Validator::make($request->all(), [
            'payment_method' => 'required|in:boleto,debito,credito,pix',
        ]);

        if ($validator->fails()) {
            Log::error('[PlanoController] Validação falhou.', $validator->errors()->toArray());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $paymentMethod = $request->input('payment_method');

        $pagamento = $mpService->criarPreferencia("Plano: {$plan->name}", $plan->price, $paymentMethod);

        if (!$pagamento['success']) {
            Log::error('[PlanoController] Erro ao criar preferência de pagamento.', ['mensagem' => $pagamento['mensagem']]);
            return redirect()->back()->with('error', $pagamento['mensagem']);
        }

        Log::info("[PlanoController] Preferência criada com sucesso para o usuário {$user->id}. Redirecionando para Mercado Pago...");

        // Redireciona para o checkout do Mercado Pago
        return redirect()->away($pagamento['url']);
    }

    // Endpoint de sucesso após retorno do Mercado Pago (para completar assinatura)
    public function sucesso(Request $request)
    {
        $user = Auth::user();

        // Aqui você pode verificar se já existe uma assinatura ativa antes de salvar
        $plano = Plan::where('price', $request->query('valor'))->first(); // opcional, pode vir do banco ou salvar no session

        if (!$plano) {
            Log::warning('[PlanoController] Plano não encontrado após pagamento.');
            return redirect()->route('home')->with('error', 'Plano não encontrado.');
        }

        $planoAtual = $user->subscriptions()
            ->where('is_active', true)
            ->with('plan')
            ->latest('end_date')
            ->first();

        $diasRestantes = 0;

        if ($planoAtual) {
            if ($plano->price < $planoAtual->plan->price) {
                return redirect()->route('planos.upgrade')
                    ->with('error', 'Você não pode fazer downgrade de plano.');
            }

            $diasRestantes = Carbon::now()->diffInDays($planoAtual->end_date, false);
            $planoAtual->update(['is_active' => false]);
        }

        $diasPlano = match ($plano->duration_in_days) {
            7, 30, 90, 365 => $plano->duration_in_days,
            default => 30,
        };

        $start = Carbon::now();
        $end = $start->copy()->addDays($diasPlano + max(0, $diasRestantes));

        $user->subscriptions()->create([
            'plan_id' => $plano->id,
            'start_date' => $start,
            'end_date' => $end,
            'is_active' => true,
            'payment_method' => $request->query('payment_method', 'mercado_pago'),
            'payment_status' => 'pago',
        ]);

        Log::info("[PlanoController] Plano '{$plano->name}' ativado para o usuário {$user->id}.");

        return redirect()->route('home')->with('success', 'Plano assinado com sucesso!');
    }

    public function upgrade()
    {
        $user = Auth::user();

        $planoAtual = $user->subscriptions()
            ->where('is_active', true)
            ->with('plan')
            ->latest('end_date')
            ->first();

        $planos = Plan::all();

        return view('planos.upgrade', compact('planoAtual', 'planos'));
    }
}
