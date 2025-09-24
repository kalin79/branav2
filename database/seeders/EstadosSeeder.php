<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('estados')->insert([
            [
                'mstatus_id' => 1,
                'nombre' => 'PENDIENTE',
                'abbreviation' => null,
                'level' => null,
                'created_user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mstatus_id' => 1,
                'nombre' => 'EN CAMINO',
                'abbreviation' => null,
                'level' => null,
                'created_user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mstatus_id' => 1,
                'nombre' => 'ENTREGADO',
                'abbreviation' => null,
                'level' => null,
                'created_user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mstatus_id' => 1,
                'nombre' => 'RECHAZADO',
                'abbreviation' => null,
                'level' => null,
                'created_user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mstatus_id' => 2,
                'nombre' => 'PENDIENTE DE PAGO',
                'abbreviation' => null,
                'level' => null,
                'created_user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mstatus_id' => 2,
                'nombre' => 'PAGADO',
                'abbreviation' => null,
                'level' => null,
                'created_user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mstatus_id' => 2,
                'nombre' => 'RECHAZADO',
                'abbreviation' => null,
                'level' => null,
                'created_user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
