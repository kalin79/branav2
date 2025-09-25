<?php

namespace App\Services;

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;

class MercadoPagoService
{
    public function __construct()
    {
        // Configurar token desde .env
        MercadoPagoConfig::setAccessToken(config('services.mercadopago.token'));
    }

    public function createPreference(array $items, $saleId = null)
    {
        $client = new PreferenceClient();

       // dd($items);
        try {
            $preference = $client->create([
                'items' => $items,
                'external_reference' => (string) $saleId,
                'back_urls' => [
                    'success' => url('/mercadopago/success'),
                    'failure' => url('/mercadopago/failure'),
                    'pending' => url('/mercadopago/pending'),
                ],
                //'auto_return' => 'approved',
                //'notification_url' => url('/api/mercadopago/webhook'),
            ]);
        } catch (\MercadoPago\Exceptions\MPApiException $e) {
            dd($e->getApiResponse()); // 👈 Esto muestra el detalle real del error
        }

        return $preference;

    }
}
