<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrigenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('origen_soportes')
                        ->insert([
                            'origen'        =>0,
                            'name'          =>'Hoja de vida',
                            'created_at'    =>now(),
                            'updated_at'    =>now()
                        ]);

        DB::table('origen_soportes')
                        ->insert([
                            'origen'        =>0,
                            'name'          =>'documento de identidad',
                            'created_at'    =>now(),
                            'updated_at'    =>now()
                        ]);

        DB::table('origen_soportes')
                        ->insert([
                            'origen'        =>0,
                            'name'          =>'licencia de conducción',
                            'created_at'    =>now(),
                            'updated_at'    =>now()
                        ]);

        DB::table('origen_soportes')
                        ->insert([
                            'origen'        =>0,
                            'name'          =>'Referencia Personal',
                            'created_at'    =>now(),
                            'updated_at'    =>now()
                        ]);

        DB::table('origen_soportes')
                        ->insert([
                            'origen'        =>1,
                            'name'          =>'Cámara de Comercio',
                            'created_at'    =>now(),
                            'updated_at'    =>now()
                        ]);

        DB::table('origen_soportes')
                        ->insert([
                            'origen'        =>1,
                            'name'          =>'RUT',
                            'created_at'    =>now(),
                            'updated_at'    =>now()
                        ]);

        DB::table('origen_soportes')
                        ->insert([
                            'origen'        =>1,
                            'name'          =>'Contrato',
                            'created_at'    =>now(),
                            'updated_at'    =>now()
                        ]);

        DB::table('origen_soportes')
                        ->insert([
                            'origen'        =>2,
                            'name'          =>'SOAT',
                            'created_at'    =>now(),
                            'updated_at'    =>now()
                        ]);

        DB::table('origen_soportes')
                        ->insert([
                            'origen'        =>2,
                            'name'          =>'Revisión Tecno - mecánica',
                            'created_at'    =>now(),
                            'updated_at'    =>now()
                        ]);

        DB::table('origen_soportes')
                        ->insert([
                            'origen'        =>2,
                            'name'          =>'Registro de Mantenimiento',
                            'created_at'    =>now(),
                            'updated_at'    =>now()
                        ]);
    }
}
