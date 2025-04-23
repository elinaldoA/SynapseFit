<?php

namespace App\Services;

use App\Models\UserSubscription;
use Carbon\Carbon;

class SubscriptionService
{
    public function getSubscriptionType($userId)
    {
        $subscription = UserSubscription::where('user_id', $userId)
            ->where('is_active', true)
            ->latest()
            ->first();

        if (!$subscription) {
            return 'Sem assinatura';
        }

        $duration = $subscription->start_date->diffInMonths($subscription->end_date);

        if ($subscription->plan->name === 'Grátis') {
            return 'Grátis';
        }

        switch ($duration) {
            case 1:
                return 'Mensal';
            case 3:
                return 'Trimestral';
            case 6:
                return 'Semestral';
            case 12:
                return 'Anual';
            default:
                return 'Outro';
        }
    }
}
