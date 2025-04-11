<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Resources\Preference\Item;

class MercadoPagoService
{
    public function __construct()
    {
        $accessToken = config('services.mercadopago.token');

        if (!$accessToken) {
            Log::error('[MercadoPagoService] Access token não encontrado. Verifique o .env e config/services.php');
            throw new \Exception('Token do Mercado Pago não configurado.');
        }

        MercadoPagoConfig::setAccessToken($accessToken);
    }

    public function criarPreferencia(string $titulo, float $valor, string $metodoPagamento): array
    {
        try {
            $client = new PreferenceClient();

            $item = new Item();
            $item->title = $titulo;
            $item->quantity = 1;
            $item->unit_price = (float) $valor;

            $preference = $client->create([
                "items" => [$item],
                "payment_methods" => [
                    "excluded_payment_types" => [],
                    "installments" => 1
                ],
                "back_urls" => [
                    "success" => route('planos.sucesso'),
                    "failure" => route('planos.upgrade'),
                    "pending" => route('planos.upgrade')
                ],
                "auto_return" => "approved"
            ]);

            Log::debug('[MercadoPagoService] Preferência criada.', [
                'preference_id' => $preference->id,
                'init_point' => $preference->init_point,
            ]);

            return [
                'success' => true,
                'url' => $preference->init_point,
            ];
        } catch (\Exception $e) {
            Log::error('[MercadoPagoService] Erro ao criar preferência.', [
                'erro' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'mensagem' => 'Erro ao processar o pagamento. Tente novamente mais tarde.',
            ];
        }
    }
}
