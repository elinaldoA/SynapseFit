<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CheckSubscription
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $now = Carbon::now();

        $subscription = $user->subscriptions()
            ->where('is_active', true)
            ->whereDate('start_date', '<=', $now)
            ->whereDate('end_date', '>=', $now)
            ->orderByDesc('end_date')
            ->first();

        /*Log::info('CheckSubscription', [
            'user_id' => $user->id,
            'now' => $now->toDateTimeString(),
            'has_valid_subscription' => $subscription !== null,
        ]);*/

        if (!$subscription) {
            // Se existia uma assinatura ativa que expirou, marca como inativa
            $assinaturaExpirada = $user->subscriptions()
                ->where('is_active', true)
                ->whereDate('end_date', '<', $now)
                ->first();

            if ($assinaturaExpirada) {
                $assinaturaExpirada->update(['is_active' => false]);
            }

            return redirect()->route('planos.index')
                ->with('error', 'Seu plano expirou ou ainda não está ativo.');
        }

        return $next($request);
    }
}
