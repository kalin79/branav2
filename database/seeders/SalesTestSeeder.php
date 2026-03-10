<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Clientes;
use App\Models\Sale;
use App\Models\SaleProduct;
use App\Models\Productos;
use App\Http\Enums\StatusSale;
use App\Http\Enums\StatusSalePay;
use Illuminate\Support\Str;

class SalesTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Crear Clientes de prueba si no existen
        $clientes = [
            [
                'nombres' => 'Juan',
                'apellidos' => 'Pérez',
                'nro_documento' => '40506070',
                'email' => 'juan.perez@example.com',
                'celular' => '987654321',
                'direccion' => 'Av. Larco 123, Miraflores',
                'password' => bcrypt('12345678'),
            ],
            [
                'nombres' => 'María',
                'apellidos' => 'García',
                'nro_documento' => '10203040',
                'email' => 'maria.garcia@example.com',
                'celular' => '999888777',
                'direccion' => 'Calle Las Camelias 456, San Isidro',
                'password' => bcrypt('12345678'),
            ]
        ];

        foreach ($clientes as $cli) {
            Clientes::firstOrCreate(['email' => $cli['email']], $cli);
        }

        $allClientes = Clientes::all();
        $allProducts = Productos::take(5)->get();

        if ($allProducts->isEmpty()) {
            // Si no hay productos, crear uno ficticio para que el seeder no falle
            $prod = Productos::create([
                'title_large' => 'Producto de Prueba',
                'precio_online' => 99.90,
                'stock' => 100,
                'slug' => 'producto-de-prueba',
                'active' => 1
            ]);
            $allProducts = collect([$prod]);
        }

        // 2. Crear 5 ventas de prueba
        for ($i = 1; $i <= 5; $i++) {
            $cliente = $allClientes->random();

            $sale = Sale::create([
                'client_id' => $cliente->id,
                'order_number' => 'ORD-' . date('Ymd') . '-' . Str::upper(Str::random(4)),
                'tipo_voucher_id' => rand(1, 2), // 1: Boleta, 2: Factura
                'status_id' => rand(1, 3), // 1: Pendiente, 2: En camino, 3: Entregado
                'status_pay' => rand(5, 6), // 5: Pendiente de pago, 6: Pagado
                'total_price' => 0, // Se calculará abajo
                'direccion' => $cliente->direccion,
                'contact_name' => $cliente->nombres . ' ' . $cliente->apellidos,
                'contact_email' => $cliente->email,
                'contact_cell_phone' => $cliente->celular,
                'created_at' => now()->subDays(rand(0, 5)),
            ]);

            $totalSale = 0;
            $itemsCount = rand(1, 3);
            $selectedProducts = $allProducts->random(min($itemsCount, $allProducts->count()));

            foreach ($selectedProducts as $prod) {
                $qty = rand(1, 2);
                $subtotal = $prod->precio_online * $qty;

                SaleProduct::create([
                    'sale_id' => $sale->id,
                    'product_id' => $prod->id,
                    'product_name' => $prod->title_large,
                    'unit_price' => $prod->precio_online,
                    'total_price' => $subtotal,
                    'quantity' => $qty,
                    'product_image' => $prod->poster,
                ]);

                $totalSale += $subtotal;
            }

            $sale->update(['total_price' => $totalSale]);
        }
    }
}
