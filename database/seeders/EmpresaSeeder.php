<?php

namespace Database\Seeders;

use App\Models\Configuracion\Area;
use App\Models\Facturacion\Empresa;
use App\Models\Facturacion\Sucursal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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

        //Asigna ciudad
        DB::table('ciudad_empresa')->insert([
            'ciudad_id'     =>1,
            'empresa_id'    =>$emp->id,
            'created_at'    =>now(),
            'updated_at'    =>now()
        ]);

        //Crear Sucursal
        $suc=Sucursal::create([
            'name'      =>'principal',
            'direccion' =>'calle 71 A Sur N° 83 b - 85',
            'empresa_id'=>$emp->id,
            'ciudad_id' =>1
        ]);

        //Crear primer área de la sucursal
        $area=Area::where('name', 'gerencia')->first();

        DB::table('area_sucursal')->insert([
            'area_id'       =>$area->id,
            'sucursal_id'   =>$suc->id,
            'created_at'    =>now(),
            'updated_at'    =>now()
        ]);

        $empr=Empresa::create([
            'nit'               => '900474371',
            'name'              => 'somos envíos y diligencias S.A.S.',
            'direccion'         => 'calle 24 A Sur N°: 63C-32',
            'telefono'          => '3104771708',
            'contacto'          =>'Ing. Diego Barajas',
            'email'             =>'somos.enviosydiligencias@gmail.com',
            'email_facturacion' =>'somos.enviosydiligencias@gmail.com',
            'seguimiento'       =>true
        ]);

            //Asigna ciudad
            DB::table('ciudad_empresa')->insert([
            'ciudad_id'     =>1,
            'empresa_id'    =>$empr->id,
            'created_at'    =>now(),
            'updated_at'    =>now()
            ]);

            //Crear Sucursal
            $sucu=Sucursal::create([
            'name'      =>'principal',
            'direccion' =>'calle 71 A Sur N° 83 b - 85',
            'empresa_id'=>$empr->id,
            'ciudad_id' =>1
            ]);

            //Crear primer área de la sucursal
            $area=Area::where('name', 'gerencia')->first();

            DB::table('area_sucursal')->insert([
            'area_id'       =>$area->id,
            'sucursal_id'   =>$sucu->id,
            'created_at'    =>now(),
            'updated_at'    =>now()
            ]);

            $empr1=Empresa::create([
                'nit'               => '900800698',
                'name'              => 'Innovate Medical Devices S.A.S.',
                'direccion'         => 'Carrera 7 B Bis # 126 - 36',
                'telefono'          => '3003477199',
                'contacto'          => 'Juan Colmenares',
                'email'             => 'imd.colombia@yahoo.com',
                'email_facturacion' => 'imd.colombia@yahoo.com',
                'seguimiento'       =>true
            ]);

                //Asigna ciudad
                DB::table('ciudad_empresa')->insert([
                'ciudad_id'     =>1,
                'empresa_id'    =>$empr1->id,
                'created_at'    =>now(),
                'updated_at'    =>now()
                ]);

                //Crear Sucursal
                $sucu=Sucursal::create([
                'name'      =>'principal',
                'direccion' =>'Carrera 7 B Bis # 126 - 36',
                'empresa_id'=>$empr1->id,
                'ciudad_id' =>1
                ]);

                //Crear primer área de la sucursal
                $area=Area::where('name', 'gerencia')->first();

                DB::table('area_sucursal')->insert([
                'area_id'       =>$area->id,
                'sucursal_id'   =>$sucu->id,
                'created_at'    =>now(),
                'updated_at'    =>now()
                ]);

                $empr1=Empresa::create([
                    'nit'               => '900346539',
                    'name'              => 'Alear Colombia S.A.S.',
                    'direccion'         => 'Av Calle 80 69-70 Bodega 36',
                    'telefono'          => '601 7561643',
                    'contacto'          => 'Lorena',
                    'email'             => 'facturacion@alear.co',
                    'email_facturacion' => 'facturacion@alear.co',
                    'seguimiento'       =>true
                ]);

                    //Asigna ciudad
                    DB::table('ciudad_empresa')->insert([
                    'ciudad_id'     =>1,
                    'empresa_id'    =>$empr1->id,
                    'created_at'    =>now(),
                    'updated_at'    =>now()
                    ]);

                    //Crear Sucursal
                    $sucu=Sucursal::create([
                    'name'      =>'principal',
                    'direccion' =>'Av Calle 80 69-70 Bodega 36',
                    'empresa_id'=>$empr1->id,
                    'ciudad_id' =>1
                    ]);

                    //Crear primer área de la sucursal
                    $area=Area::where('name', 'gerencia')->first();

                    DB::table('area_sucursal')->insert([
                    'area_id'       =>$area->id,
                    'sucursal_id'   =>$sucu->id,
                    'created_at'    =>now(),
                    'updated_at'    =>now()
                    ]);

                    $empr1=Empresa::create([
                        'nit'               => '900277244',
                        'name'              => 'Helpharma S.A.S.',
                        'direccion'         => 'Calle 31 13 A 51 Of 319',
                        'telefono'          => '601 6052555',
                        'contacto'          => 'dra. Tania Figueroa',
                        'email'             => 'recepciontecnica@helpharma.com',
                        'email_facturacion' => 'recepciontecnica@helpharma.com',
                        'seguimiento'       =>true
                    ]);

                        //Asigna ciudad
                        DB::table('ciudad_empresa')->insert([
                        'ciudad_id'     =>1,
                        'empresa_id'    =>$empr1->id,
                        'created_at'    =>now(),
                        'updated_at'    =>now()
                        ]);

                        //Crear Sucursal
                        $sucu=Sucursal::create([
                        'name'      =>'principal',
                        'direccion' =>'Calle 31 13 A 51 Of 319',
                        'empresa_id'=>$empr1->id,
                        'ciudad_id' =>1
                        ]);

                        //Crear primer área de la sucursal
                        $area=Area::where('name', 'gerencia')->first();

                        DB::table('area_sucursal')->insert([
                        'area_id'       =>$area->id,
                        'sucursal_id'   =>$sucu->id,
                        'created_at'    =>now(),
                        'updated_at'    =>now()
                        ]);
    }
}
