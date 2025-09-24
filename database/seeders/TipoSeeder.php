<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class TipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipos')->insert([
            [
                'mtype_id' => 1,
                'nombre' => 'Boleta',
                'parent_id' => null,
                'created_user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mtype_id' => 1,
                'nombre' => 'Factura',
                'parent_id' => null,
                'created_user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
