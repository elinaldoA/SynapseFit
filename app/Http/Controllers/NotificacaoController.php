<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PushSubscription;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;
use Illuminate\Support\Facades\Log;

class NotificacaoController extends Controller
{
    public function __construct()
    {
        // Garante que apenas usuários autenticados acessem os métodos
        $this->middleware('auth');
    }

    public function salvar(Request $request)
    {
        try {
            $data = $request->all();

            Log::info('Recebendo subscription:', $data);

            if (!isset($data['endpoint']) || !isset($data['keys']['p256dh']) || !isset($data['keys']['auth'])) {
                Log::error('Subscription inválida: dados incompletos.');
                return response()->json(['success' => false, 'message' => 'Dados da subscription incompletos'], 400);
            }

            PushSubscription::updateOrCreate(
                ['endpoint' => $data['endpoint']],
                ['subscription' => json_encode($data)]
            );

            Log::info('Subscription salva/atualizada com sucesso.');

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Erro ao salvar subscription: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Erro ao salvar subscription'], 500);
        }
    }

    public function enviar()
    {
        try {
            $auth = [
                'VAPID' => [
                    'subject' => config('services.vapid.subject'),
                    'publicKey' => config('services.vapid.public_key'),
                    'privateKey' => config('services.vapid.private_key'),
                ],
            ];

            Log::info('Configuração VAPID:', $auth['VAPID']);

            $webPush = new WebPush($auth);
            $webPush->setReuseVAPIDHeaders(true);

            $subscriptions = PushSubscription::all();
            Log::info('Total de subscriptions:', ['count' => count($subscriptions)]);

            foreach ($subscriptions as $sub) {
                try {
                    $data = json_decode($sub->subscription, true);

                    Log::info('Enviando para endpoint:', ['endpoint' => $data['endpoint']]);

                    $subscription = Subscription::create([
                        'endpoint' => $data['endpoint'],
                        'publicKey' => $data['keys']['p256dh'],
                        'authToken' => $data['keys']['auth'],
                    ]);

                    $payload = json_encode([
                        'title' => 'Notificação de Teste',
                        'body' => 'Esse é um teste de notificação com VAPID 🔔',
                    ]);

                    $report = $webPush->sendOneNotification($subscription, $payload);

                    if ($report->isSuccess()) {
                        Log::info('Notificação enviada com sucesso para ' . $data['endpoint']);
                    } else {
                        Log::warning('Falha ao enviar notificação.', ['endpoint' => $data['endpoint'], 'reason' => $report->getReason()]);
                    }
                } catch (\Exception $ex) {
                    Log::error('Erro ao enviar notificação para subscription: ' . $ex->getMessage());
                }
            }

            return back()->with('success', 'Notificação enviada!');
        } catch (\Exception $e) {
            Log::error('Erro geral ao enviar notificações: ' . $e->getMessage());
            return back()->with('error', 'Erro ao enviar notificações.');
        }
    }
}
