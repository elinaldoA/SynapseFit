<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckSubscriptionPayment
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user) {
            $subscription = $user->subscriptions()
                ->where('is_active', true)
                ->latest('end_date')
                ->first();

            if ($subscription && $subscription->payment_status === 'pendente') {
                return redirect()->route('planos.pendentes')
                    ->with('error', 'Seu pagamento está pendente. Conclua o pagamento para continuar.');
            }
        }

        return $next($request);
    }
}
