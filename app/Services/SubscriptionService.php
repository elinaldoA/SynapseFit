<?php

namespace App\Services;

use App\Models\UserSubscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

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

    public function getRemainingDays($userId)
    {
        $subscription = UserSubscription::where('user_id', $userId)
            ->where('is_active', true)
            ->latest()
            ->first();

        if (!$subscription) {
            return 0;
        }

        $endDate = Carbon::parse($subscription->end_date);
        $remainingDays = Carbon::now()->diffInDays($endDate, false);

        return max((int) $remainingDays, 0);
    }

    // Novo método para enviar notificação de vencimento
    public function checkAndNotifySubscriptionExpiry($userId)
    {
        $subscription = UserSubscription::where('user_id', $userId)
            ->where('is_active', true)
            ->latest()
            ->first();

        if (!$subscription) {
            return;
        }

        $endDate = Carbon::parse($subscription->end_date);
        $remainingDays = (int) Carbon::now()->diffInDays($endDate, false);

        if ($remainingDays <= 0) {
            $this->notifyUser($userId, 'Sua assinatura venceu!');
        } elseif ($remainingDays <= 7) {
            $texto = $remainingDays === 1
                ? 'Sua assinatura está prestes a vencer em 1 dia.'
                : "Sua assinatura está prestes a vencer em $remainingDays dias.";

            $this->notifyUser($userId, $texto);
        }
    }

    protected function notifyUser($userId, $message)
    {
        $user = User::find($userId);

        if ($user) {
            Notification::send($user, new \App\Notifications\SubscriptionExpiryNotification($message));
        }
    }

    public function renewSubscription($subscriptionId)
    {
        $subscription = UserSubscription::find($subscriptionId);

        if (!$subscription) {
            return false;
        }

        $duration = Carbon::parse($subscription->start_date)->diffInDays(Carbon::parse($subscription->end_date));

        $subscription->start_date = Carbon::now();
        $subscription->end_date = Carbon::now()->addDays($duration);
        $subscription->is_active = true;
        $subscription->save();

        return true;
    }

    public function cancelSubscription($subscriptionId)
    {
        $subscription = UserSubscription::find($subscriptionId);

        if (!$subscription) {
            return false;
        }

        $subscription->end_date = Carbon::now();
        $subscription->is_active = false;
        $subscription->save();

        return true;
    }
}
