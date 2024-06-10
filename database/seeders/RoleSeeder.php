<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Superusuario=Role::create(['name'=>'Superusuario']);
        $Financiero=Role::create(['name'=>'Financiero']);
        $OperacionesGeneral=Role::create(['name'=>'OperacionesGeneral']);
        $OperacionesEmpresa=Role::create(['name'=>'OperacionesEmpresa']);
        $Administrativo=Role::create(['name'=>'Administrativo']);
        $Auxiliar=Role::create(['name'=>'Auxiliar']);
        $Usuario=Role::create(['name'=>'Usuario']);
        $Mensajero=Role::create(['name'=>'Mensajero']);

        Permission::create([
                    'name'=>'Configuracion',
                    'descripcion'=>'ingreso al menú configuracion',
                    'modulo'=>'configuracion'
                    ])->syncRoles([$Superusuario,$OperacionesGeneral,$Administrativo]);

        Permission::create([
                    'name'=>'co_users',
                    'descripcion'=>'Ver listado de usuarios registrados en el sistema',
                    'modulo'=>'configuracion'
                    ])->syncRoles([$Superusuario,$OperacionesGeneral,$Administrativo]);

        Permission::create([
                    'name'=>'co_rols',
                    'descripcion'=>'Ver listado de roles registrados en el sistema',
                    'modulo'=>'configuracion'
                    ])->syncRoles([$Superusuario,$OperacionesGeneral,$Administrativo]);

        Permission::create([
                    'name'=>'co_areas',
                    'descripcion'=>'Ver listado de áreas registrados en el sistema',
                    'modulo'=>'configuracion'
                    ])->syncRoles([$Superusuario,$OperacionesGeneral,$Administrativo]);

        Permission::create([
                    'name'=>'co_ciudads',
                    'descripcion'=>'Ver listado de ciudades registrados en el sistema',
                    'modulo'=>'configuracion'
                    ])->syncRoles([$Superusuario,$OperacionesGeneral,$Administrativo]);

        Permission::create([
                    'name'=>'Diligencias',
                    'descripcion'=>'ingreso al menú diligencias',
                    'modulo'=>'diligencias'
                    ])->syncRoles([$Superusuario,$Financiero,$OperacionesEmpresa,$OperacionesGeneral,$Auxiliar,$Administrativo,$Mensajero,$Usuario]);

        Permission::create([
                    'name'=>'di_diligencias',
                    'descripcion'=>'Ver listado de diligencias',
                    'modulo'=>'diligencias'
                    ])->syncRoles([$Superusuario,$OperacionesEmpresa,$OperacionesGeneral,$Administrativo,$Auxiliar,$Mensajero,$Usuario]);

        Permission::create([
                    'name'=>'Humana',
                    'descripcion'=>'ingreso al menú Humana',
                    'modulo'=>'humana'
                    ])->syncRoles([$Superusuario,$Financiero,$OperacionesGeneral,$Auxiliar,$Administrativo,$Mensajero]);

        Permission::create([
                    'name'=>'no_nomina',
                    'descripcion'=>'Ver registros de nómina',
                    'modulo'=>'humana'
                    ])->syncRoles([$Superusuario,$Financiero,$OperacionesGeneral,$Auxiliar,$Administrativo,$Mensajero]);

        Permission::create([
                    'name'=>'Financiera',
                    'descripcion'=>'ingreso al menú financiera',
                    'modulo'=>'financiera'
                    ])->syncRoles([$Superusuario,$Financiero,$Administrativo]);

        Permission::create([
                    'name'=>'Facturacion',
                    'descripcion'=>'ingreso al menú Facturacion',
                    'modulo'=>'Facturacion'
                    ])->syncRoles([$Superusuario,$Financiero,$Administrativo]);

        Permission::create([
                    'name'=>'fi_facturas',
                    'descripcion'=>'listado de facturas.',
                    'modulo'=>'Facturacion'
                    ])->syncRoles([$Superusuario,$Financiero,$Administrativo]);

        Permission::create([
            'name'=>'PESV',
            'descripcion'=>'ingreso al menú PESV',
            'modulo'=>'pesv'
            ])->syncRoles([$Superusuario,$Financiero,$OperacionesEmpresa,$OperacionesGeneral,$Auxiliar,$Administrativo,$Mensajero,$Usuario]);

        Permission::create([
                    'name'=>'pe_hv_vehiculos',
                    'descripcion'=>'Ver listado de hojas de vida de los vehiculos',
                    'modulo'=>'pesv'
                    ])->syncRoles([$Superusuario,$OperacionesEmpresa,$OperacionesGeneral,$Administrativo,$Auxiliar,$Mensajero,$Usuario]);

    }
}
