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
        $Superusuario=Role::where('name','Superusuario')->first();
        $Financiero=Role::where('name','Financiero')->first();
        $Administrativo=Role::where('name','Administrativo')->first();

        Permission::create([
            'name'=>'hu_salarios',
            'descripcion'=>'Ver listado de salarios',
            'modulo'=>'humana'
        ])->syncRoles([$Superusuario,$Financiero]);

        Permission::create([
            'name'=>'hu_salariosModify',
            'descripcion'=>'Modificar salario',
            'modulo'=>'humana'
        ])->syncRoles([$Superusuario,$Financiero]);


        /*

        Permission::create([
            'name'=>'hu_adicionales',
            'descripcion'=>'Ver listado de costos adicionales',
            'modulo'=>'humana'
        ])->syncRoles([$Superusuario,$Financiero]);

        Permission::create([
            'name'=>'hu_adicionalesModify',
            'descripcion'=>'Modificar costo adicional',
            'modulo'=>'humana'
        ])->syncRoles([$Superusuario,$Financiero]);

        Permission::create([
            'name'=>'fi_carteras',
            'descripcion'=>'Ver lista de carteras',
            'modulo'=>'financiera'
        ])->syncRoles([$Superusuario,$Financiero,$Administrativo]);

        Permission::create([
            'name'=>'fi_carterasModify',
            'descripcion'=>'Editar carteras registrados',
            'modulo'=>'financiera'
        ])->syncRoles([$Superusuario,$Financiero,$Administrativo]);

        Permission::create([
                'name'=>'hu_contratos',
                'descripcion'=>'Ver listado de contratos',
                'modulo'=>'humana'
            ])->syncRoles([$Superusuario,$Financiero]);

        Permission::create([
                'name'=>'hu_contratosModify',
                'descripcion'=>'Modificar Contrato',
                'modulo'=>'humana'
            ])->syncRoles([$Superusuario,$Financiero]);



        Permission::create([
                    'name'=>'fi_cuentasp',
                    'descripcion'=>'Ver lista de cuentas por pagar',
                    'modulo'=>'financiera'
            ])->syncRoles([$Superusuario,$Financiero,$Administrativo]);


        Permission::create([
                    'name'=>'fi_cxpModify',
                    'descripcion'=>'Editar cuentas por pagar',
                    'modulo'=>'financiera'
            ])->syncRoles([$Superusuario,$Financiero,$Administrativo]);

        --DESDE ACÁ




        $Superusuario=Role::create(['name'=>'Superusuario']);
        $Financiero=Role::create(['name'=>'Financiero']);
        $OperacionesGeneral=Role::create(['name'=>'OperacionesGeneral']);
        $OperacionesEmpresa=Role::create(['name'=>'OperacionesEmpresa']);
        $Administrativo=Role::create(['name'=>'Administrativo']);
        $Auxiliar=Role::create(['name'=>'Auxiliar']);
        $AdminEmpresa=Role::create(['name'=>'AdminEmpresa']);
        $AuxEmpresa=Role::create(['name'=>'AuxEmpresa']);
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
                        'name'=>'co_userModify',
                        'descripcion'=>'Modificar - crear usuarios',
                        'modulo'=>'configuracion'
                        ])->syncRoles([$Superusuario,$OperacionesGeneral,$Administrativo]);

        Permission::create([
                        'name'=>'co_usersPerfil',
                        'descripcion'=>'Revisar perfiles de los usuarios',
                        'modulo'=>'configuracion'
                        ])->syncRoles([$Superusuario,$OperacionesGeneral,$Administrativo]);

        Permission::create([
                    'name'=>'co_rols',
                    'descripcion'=>'Ver listado de roles registrados en el sistema',
                    'modulo'=>'configuracion'
                    ])->syncRoles([$Superusuario,$OperacionesGeneral,$Administrativo]);

        Permission::create([
                    'name'=>'co_rolModify',
                    'descripcion'=>'Editar roles dentro del sistema',
                    'modulo'=>'configuracion'
                    ])->syncRoles([$Superusuario,$OperacionesGeneral]);

        Permission::create([
                    'name'=>'co_rolCrea',
                    'descripcion'=>'Crea roles dentro del sistema',
                    'modulo'=>'configuracion'
                    ])->syncRoles([$Superusuario]);


        Permission::create([
                    'name'=>'co_areas',
                    'descripcion'=>'Ver listado de áreas registrados en el sistema',
                    'modulo'=>'configuracion'
                    ])->syncRoles([$Superusuario,$OperacionesGeneral,$Administrativo]);

        Permission::create([
                    'name'=>'co_areaModify',
                    'descripcion'=>'Crear - Editar áreas dentro del sistema',
                    'modulo'=>'configuracion'
                    ])->syncRoles([$Superusuario,$OperacionesGeneral,$Administrativo]);

        Permission::create([
                    'name'=>'co_ciudadModify',
                    'descripcion'=>'Crear - Editar Ciudades',
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
                    ])->syncRoles([$Superusuario,$Financiero,$OperacionesEmpresa,$OperacionesGeneral,$Auxiliar,$Administrativo, $AdminEmpresa,$AuxEmpresa,$Mensajero,$Usuario]);

        Permission::create([
                    'name'=>'di_diligencias',
                    'descripcion'=>'Ver listado de diligencias',
                    'modulo'=>'diligencias'
                    ])->syncRoles([$Superusuario,$OperacionesEmpresa,$OperacionesGeneral,$Administrativo,$AdminEmpresa,$AuxEmpresa,$Auxiliar,$Mensajero,$Usuario]);

        Permission::create([
                    'name'=>'di_diligenciaModify',
                    'descripcion'=>'Crear y editar diligencias',
                    'modulo'=>'diligencias'
                    ])->syncRoles([$Superusuario,$OperacionesEmpresa,$OperacionesGeneral,$Administrativo,$Auxiliar,$Mensajero,$Usuario]);

        Permission::create([
                    'name'=>'di_diligestion',
                    'descripcion'=>'Acceso a Menú de gestión de diligencias desde Principal',
                    'modulo'=>'diligencias'
                    ])->syncRoles([$Superusuario,$OperacionesGeneral,$Administrativo,$Auxiliar]);

        Permission::create([
                    'name'=>'di_diligeModify',
                    'descripcion'=>'Gestión de diligencias con los operadores',
                    'modulo'=>'diligencias'
                    ])->syncRoles([$Superusuario,$OperacionesGeneral,$Administrativo,$Auxiliar]);

        Permission::create([
                    'name'=>'di_diligestmensa',
                    'descripcion'=>'Gestión como mensajero',
                    'modulo'=>'diligencias'
                    ])->syncRoles([$Superusuario,$Mensajero]);

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
                    'name'=>'fi_bancos',
                    'descripcion'=>'Ver lista de bancos',
                    'modulo'=>'financiera'
                    ])->syncRoles([$Superusuario,$Financiero]);

        Permission::create([
                    'name'=>'fi_bancosModify',
                    'descripcion'=>'Editar bancos registrados',
                    'modulo'=>'financiera'
                    ])->syncRoles([$Superusuario,$Financiero]);

        Permission::create([
                    'name'=>'fi_conceptos',
                    'descripcion'=>'Ver lista de conceptos',
                    'modulo'=>'financiera'
                    ])->syncRoles([$Superusuario,$Financiero]);

        Permission::create([
                        'name'=>'fi_conceptosModify',
                        'descripcion'=>'Editar tipos de conceptos',
                        'modulo'=>'financiera'
                        ])->syncRoles([$Superusuario,$Financiero]);

        Permission::create([
                        'name'=>'fi_movimientos',
                        'descripcion'=>'Ver movimientos',
                        'modulo'=>'financiera'
                        ])->syncRoles([$Superusuario,$Financiero]);

        Permission::create([
                            'name'=>'fi_movimientosModify',
                            'descripcion'=>'Crear - Editar Movimientos',
                            'modulo'=>'financiera'
                            ])->syncRoles([$Superusuario,$Financiero]);


        Permission::create([
                    'name'=>'Facturacion',
                    'descripcion'=>'ingreso al menú Facturacion',
                    'modulo'=>'Facturacion'
                    ])->syncRoles([$Superusuario,$Financiero,$Administrativo]);

        Permission::create([
                    'name'=>'fa_empresas',
                    'descripcion'=>'ver empresas',
                    'modulo'=>'Facturacion'
                    ])->syncRoles([$Superusuario,$Financiero,$Administrativo]);

        Permission::create([
                        'name'=>'fa_empresasCrear',
                        'descripcion'=>'Crear empresas',
                        'modulo'=>'Facturacion'
                        ])->syncRoles([$Superusuario,$Financiero,$Administrativo]);

        Permission::create([
                        'name'=>'fa_empresamodify',
                        'descripcion'=>'Editar empresas',
                        'modulo'=>'Facturacion'
                        ])->syncRoles([$Superusuario,$Financiero,$Administrativo]);

        Permission::create([
                            'name'=>'fa_empresasInactivar',
                            'descripcion'=>'Inactivar empresas',
                            'modulo'=>'Facturacion'
                            ])->syncRoles([$Superusuario,$Financiero,$Administrativo]);


        Permission::create([
                        'name'=>'fa_listas',
                        'descripcion'=>'ver listas de precios',
                        'modulo'=>'Facturacion'
                        ])->syncRoles([$Superusuario,$Financiero,$Administrativo]);

        Permission::create([
                        'name'=>'fa_listasCrear',
                        'descripcion'=>'Crear listas de precios',
                        'modulo'=>'Facturacion'
                        ])->syncRoles([$Superusuario,$Financiero]);

        Permission::create([
                    'name'=>'fa_listamodify',
                    'descripcion'=>'Editar listas de precios',
                    'modulo'=>'Facturacion'
                    ])->syncRoles([$Superusuario,$Financiero]);

        Permission::create([
                        'name'=>'fa_productos',
                        'descripcion'=>'ver productos',
                        'modulo'=>'Facturacion'
                        ])->syncRoles([$Superusuario,$Financiero,$Administrativo]);

        Permission::create([
                    'name'=>'fa_productomodify',
                    'descripcion'=>'Editar productos',
                    'modulo'=>'Facturacion'
                    ])->syncRoles([$Superusuario,$Financiero]);

        Permission::create([
                    'name'=>'fa_facturas',
                    'descripcion'=>'listado de facturas.',
                    'modulo'=>'Facturacion'
                    ])->syncRoles([$Superusuario,$Financiero,$Administrativo]);

        Permission::create([
                        'name'=>'fa_facturamodify',
                        'descripcion'=>'modificar facturas.',
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
 */
    }
}
