<?php

namespace App\Services;

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;

class MercadoPagoService
{
    public function __construct()
    {
        // Aquí usas las credenciales de tu .env
        MercadoPagoConfig::setAccessToken(config('services.mercadopago.token'));
    }

    public function createPreference(array $items, $saleId = null)
    {
        $client = new PreferenceClient();

        return $client->create([
            'items' => $items,
            'external_reference' => $saleId, // identificador de tu venta
            'back_urls' => [
                'success' => route('mp.success'),
                'failure' => route('mp.failure'),
                'pending' => route('mp.pending'),
            ],
            'auto_return' => 'approved',
            'notification_url' => route('mp.webhook'), // webhook
        ]);
    }
}
