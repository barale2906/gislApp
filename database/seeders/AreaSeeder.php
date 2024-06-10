<?php

namespace Database\Seeders;

use App\Models\Configuracion\Area;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Area::create([
            'name'        =>'gerencia',
        ]);

        Area::create([
            'name'        =>'comercial',
        ]);

        Area::create([
            'name'        =>'recepción',
        ]);

        Area::create([
            'name'        =>'almacén',
        ]);

        Area::create([
            'name'        =>'distribuciones',
        ]);

        Area::create([
            'name'        =>'correspondencia',
        ]);

        Area::create([
            'name'        =>'contabilidad',
        ]);

        Area::create([
            'name'        =>'cartera',
        ]);
    }
}
