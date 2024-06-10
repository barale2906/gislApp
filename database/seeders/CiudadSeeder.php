<?php

namespace Database\Seeders;

use App\Models\Configuracion\Ciudad;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CiudadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ciudad::create([
            'name'        =>'bogotá',
            'codigopostal'  =>'110011'
        ]);

        Ciudad::create([
            'name'        =>'medellin',
            'codigopostal'  =>'050011'
        ]);

        Ciudad::create([
            'name'        =>'barranquilla',
            'codigopostal'  =>'070012'
        ]);

        Ciudad::create([
            'name'        =>'bucaramanga',
            'codigopostal'  =>'680001'
        ]);

        Ciudad::create([
            'name'        =>'pereira',
            'codigopostal'  =>'660001'
        ]);

        Ciudad::create([
            'name'        =>'cali',
            'codigopostal'  =>'760001'
        ]);
    }
}
