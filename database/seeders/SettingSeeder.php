<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::updateOrCreate(['key' => 'precio_delivery'], [
            'value' => '10.00',
            'type'  => 'decimal',
            'description' => 'Costo de envío por delivery'
        ]);

        Setting::updateOrCreate(['key' => 'monto_descuento'], [
            'value' => '10',
            'type'  => 'integer',
            'description' => 'Descuento fijo aplicado a la venta'
        ]);

        Setting::updateOrCreate(['key' => 'monto_descuento_producto'], [
            'value' => '10',
            'type'  => 'decimal',
            'description' => 'Descuento fijo aplicado a la venta'
        ]);
    }
}
