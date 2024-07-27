<?php

namespace Database\Seeders;

use App\Models\Financiera\Concepto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConceptoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Concepto::create([
            'concepto'      =>strtolower('Transferencia cliente'),
            'tipo'          =>true,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('Transferencia interna'),
            'tipo'          =>true,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('pago en efectivo'),
            'tipo'          =>true,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('intereses ahorros'),
            'tipo'          =>true,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('ajuste crédito'),
            'tipo'          =>true,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('Ajuste débito'),
            'tipo'          =>false,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('4 * 1000'),
            'tipo'          =>false,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('cuota manejo'),
            'tipo'          =>false,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('retiro cajero'),
            'tipo'          =>false,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('retiro corresponsal'),
            'tipo'          =>false,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('traslado interno'),
            'tipo'          =>false,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('pago planilla Y'),
            'tipo'          =>false,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('pago planilla E'),
            'tipo'          =>false,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('pago operador nómina'),
            'tipo'          =>false,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('pago operador prestación'),
            'tipo'          =>false,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('pago contador'),
            'tipo'          =>false,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('pago SGSST'),
            'tipo'          =>false,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('pago servicios públicos telefonia celular'),
            'tipo'          =>false,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('pago servicios públicos fijo - internet'),
            'tipo'          =>false,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('pago servicios públicos energía'),
            'tipo'          =>false,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('pago servicios públicos gas'),
            'tipo'          =>false,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('pago servicios públicos acueducto'),
            'tipo'          =>false,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('pago con tarjeta debito'),
            'tipo'          =>false,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('costo interbancario'),
            'tipo'          =>false,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('IVA costo interbancario'),
            'tipo'          =>false,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('TRANSFERENCIA PROVEEDOR'),
            'tipo'          =>false,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('pago SITP'),
            'tipo'          =>false,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('pago propios empresa'),
            'tipo'          =>false,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('pago DIAN'),
            'tipo'          =>false,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('pago IMPUESTOS DISTRITALES'),
            'tipo'          =>false,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('prestamo a empleados'),
            'tipo'          =>false,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('pago prestamo empleados'),
            'tipo'          =>true,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('costo nomina: pago cesantias'),
            'tipo'          =>false,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('costo nomina: provisión cesantias'),
            'tipo'          =>true,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('costo nomina: pago dotaciones'),
            'tipo'          =>false,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('costo nomina: provisión dotaciones'),
            'tipo'          =>true,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('costo nomina: pago vacaciones'),
            'tipo'          =>false,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('costo nomina: provisión vacaciones'),
            'tipo'          =>true,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('costo nomina: pago primas'),
            'tipo'          =>false,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('costo nomina: provisión primas'),
            'tipo'          =>true,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('costo nomina: pago intereses cesantias'),
            'tipo'          =>false,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('costo nomina: provisión intereses cesantias'),
            'tipo'          =>true,
        ]);

        Concepto::create([
            'concepto'      =>strtolower('pago Taxis Clientes'),
            'tipo'          =>false,
        ]);

    }
}
