<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\UserSubscription;
use App\Services\SubscriptionService;

class AssinaturaController extends Controller
{
    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function index()
    {
        $assinaturas = UserSubscription::with(['user', 'plan'])->paginate(10);

        $assinaturas->transform(function ($assinatura) {
            $assinatura->tipo = $this->subscriptionService->getSubscriptionType($assinatura->user_id);
            $assinatura->dias_restantes = $this->subscriptionService->getRemainingDays($assinatura->user_id);
            $assinatura->status = $assinatura->end_date->isPast() ? 'Expirada' : 'Ativa';
            return $assinatura;
        });

        return view('administrador.assinaturas.index', compact('assinaturas'));
    }

    public function renovar($id)
    {
        $sucesso = $this->subscriptionService->renewSubscription($id);

        if ($sucesso) {
            return redirect()->route('assinaturas')->with('success', 'Assinatura renovada com sucesso!');
        }

        return redirect()->route('assinaturas')->with('error', 'Não foi possível renovar a assinatura.');
    }

    public function cancelar($id)
    {
        $sucesso = $this->subscriptionService->cancelSubscription($id);

        if ($sucesso) {
            return redirect()->route('assinaturas')->with('success', 'Assinatura cancelada com sucesso!');
        }

        return redirect()->route('assinaturas')->with('error', 'Não foi possível cancelar a assinatura.');
    }
}
