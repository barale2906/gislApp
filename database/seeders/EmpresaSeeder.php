<?php

namespace Database\Seeders;

use App\Models\Facturacion\Empresa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $emp=Empresa::create([
            'nit'               => '901713998',
            'name'              => 'gisla mensajería creatividad y tecnología S.A.S.',
            'direccion'         => 'calle 71 A Sur N° 83 b - 85',
            'telefono'          => '3002172663',
            'contacto'          =>'Ing. Alexander Barajas Vargas',
            'email'             =>'gislasas@gmail.com',
            'email_facturacion' =>'gislasas@gmail.com',
            'seguimiento'       =>true
        ]);
    }
}
