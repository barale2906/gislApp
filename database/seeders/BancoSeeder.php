<?php

namespace Database\Seeders;

use App\Models\Financiera\Banco;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BancoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Banco::create([
            'nombre'    =>strtolower('principal'),
            'banco'     =>strtolower('bancolombia'),
            'numero'    =>strtolower('215-000027-71'),
            'tipo'      =>strtolower('ahorros'),
        ]);

        Banco::create([
            'nombre'    =>strtolower('diego - ef-ahorros'),
            'banco'     =>strtolower('bancolombia'),
            'numero'    =>strtolower('113-000007-07'),
            'tipo'      =>strtolower('ahorros'),
        ]);

        Banco::create([
            'nombre'    =>strtolower('daniela - ef-ahorros'),
            'banco'     =>strtolower('bancolombia'),
            'numero'    =>strtolower('215-000027-72'),
            'tipo'      =>strtolower('ahorros'),
        ]);

        Banco::create([
            'nombre'    =>strtolower('daniela - ef-nequi'),
            'banco'     =>strtolower('bancolombia'),
            'numero'    =>strtolower('3016219393'),
            'tipo'      =>strtolower('nequi'),
        ]);

        Banco::create([
            'nombre'    =>strtolower('diego - ef-nequi'),
            'banco'     =>strtolower('bancolombia'),
            'numero'    =>strtolower('3112611747'),
            'tipo'      =>strtolower('nequi'),
        ]);

        Banco::create([
            'nombre'    =>strtolower('diego - ef-davi'),
            'banco'     =>strtolower('davivienda'),
            'numero'    =>strtolower('3112611747'),
            'tipo'      =>strtolower('daviplata'),
        ]);

        Banco::create([
            'nombre'    =>strtolower('efectivo'),
            'banco'     =>strtolower('nn'),
            'numero'    =>strtolower('--'),
            'tipo'      =>strtolower('--'),
        ]);
    }
}
