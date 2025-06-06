<?php

namespace Database\Seeders;

use App\Models\Configuracion\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Menu::create([
            'permiso'           => 'hu_plantas',
            'ruta'              => 'humana.plantas',
            'identificaRuta'    => 'humana.plantas',
            'name'              => 'Planta Personal',
            'icono'             => 'fa-solid fa-people-group text-gray-500',
            'menu_id'           => 10
        ]);

        Menu::create([
            'permiso'           => 'hu_nominas',
            'ruta'              => 'humana.devengados',
            'identificaRuta'    => 'humana.devengados',
            'name'              => 'Nómina',
            'icono'             => 'fa-solid fa-money-check-dollar text-gray-500',
            'menu_id'           => 10
        ]);

        Menu::create([
            'permiso'           => 'hu_salarios',
            'ruta'              => 'humana.salarios',
            'identificaRuta'    => 'humana.salarios',
            'name'              => 'Salarios',
            'icono'             => 'fa-solid fa-money-bill-1-wave text-gray-500',
            'menu_id'           => 10
        ]);

        Menu::create([
            'permiso'           => 'hu_adicionales',
            'ruta'              => 'humana.adicionales',
            'identificaRuta'    => 'humana.adicionales',
            'name'              => 'Contratos - Adicionales',
            'icono'             => 'fa-solid fa-person-digging text-gray-500',
            'menu_id'           => 10
        ]);

        Menu::create([
            'permiso'           => 'hu_contratos',
            'ruta'              => 'humana.contratos',
            'identificaRuta'    => 'humana.contratos',
            'name'              => 'Contratos',
            'icono'             => 'fa-solid fa-file-signature text-gray-500',
            'menu_id'           => 10
        ]);

        Menu::create([
            'permiso'           => 'hu_inasistencias',
            'ruta'              => 'humana.inasistencias',
            'identificaRuta'    => 'humana.inasistencias',
            'name'              => 'Inasistencias',
            'icono'             => 'fa-regular fa-hourglass text-gray-500',
            'menu_id'           => 10
        ]);

        Menu::create([
            'permiso'           => 'fi_cxp',
            'ruta'              => 'financiera.cuentasp',
            'identificaRuta'    => 'financiera.cuentasp',
            'name'              => 'Cuentas X Pagar',
            'icono'             => 'fa-solid fa-comment-dollar text-gray-500',
            'menu_id'           => 16
        ]);

        Menu::create([
            'permiso'           => 'fi_carteras',
            'ruta'              => 'financiera.carteras',
            'identificaRuta'    => 'financiera.carteras',
            'name'              => 'Cartera',
            'icono'             => 'fa-solid fa-cash-register text-gray-500',
            'menu_id'           => 16
        ]);


        /*
        -- DESDE ACÁ
        $m1=Menu::create([
            'name'              => 'CONFIGURACIÓN',
            'identificaRuta'    => 'configuracion.*',
            'permiso'           => 'Configuracion',
            'icono'             => 'fa-solid fa-screwdriver-wrench'
        ]);

        Menu::create([
                    'permiso'           => 'co_users',
                    'ruta'              => 'configuracion.users',
                    'identificaRuta'    => 'configuracion.users',
                    'name'              => 'Usuarios',
                    'icono'             => 'fa-solid fa-users text-gray-500',
                    'menu_id'           => $m1->id
                ]);

        Menu::create([
                    'permiso'           => 'co_rols',
                    'ruta'              => 'configuracion.roles',
                    'identificaRuta'    => 'configuracion.roles',
                    'name'              => 'Roles',
                    'icono'             => 'fa-solid fa-wand-sparkles text-gray-500',
                    'menu_id'           => $m1->id
                ]);

        Menu::create([
                    'permiso'           => 'co_ciudads',
                    'ruta'              => 'configuracion.ciudades',
                    'identificaRuta'    => 'configuracion.ciudades',
                    'name'              => 'Ciudades',
                    'icono'             => 'fa-solid fa-mountain-city text-gray-500',
                    'menu_id'           => $m1->id
                ]);

        Menu::create([
                    'permiso'           => 'co_areas',
                    'ruta'              => 'configuracion.areas',
                    'identificaRuta'    => 'configuracion.areas',
                    'name'              => 'Areas',
                    'icono'             => 'fa-solid fa-stapler text-gray-500',
                    'menu_id'           => $m1->id
                ]);

        $m2=Menu::create([
                    'name'              => 'DILIGENCIAS',
                    'identificaRuta'    => 'diligencia.*',
                    'permiso'           => 'Diligencias',
                    'icono'             => 'fa-solid fa-motorcycle'
                ]);

        Menu::create([
                    'permiso'           => 'di_diligencias',
                    'ruta'              => 'diligencia.diligencias',
                    'identificaRuta'    => 'diligencia.diligencias',
                    'name'              => 'Diligencias',
                    'icono'             => 'fa-solid fa-truck-plane text-gray-500',
                    'menu_id'           => $m2->id
                ]);

        Menu::create([
                    'permiso'           => 'di_diligestion',
                    'ruta'              => 'diligencia.gestion',
                    'identificaRuta'    => 'diligencia.gestion',
                    'name'              => 'Gestión',
                    'icono'             => 'fa-solid fa-list-check text-gray-500',
                    'menu_id'           => $m2->id
                ]);

        Menu::create([
                    'permiso'           => 'di_diligestmensa',
                    'ruta'              => 'diligencia.mensajero',
                    'identificaRuta'    => 'diligencia.mensajero',
                    'name'              => 'Mensajero',
                    'icono'             => 'fa-solid fa-truck-ramp-box text-gray-500',
                    'menu_id'           => $m2->id
                ]);

        $m3=Menu::create([
                    'name'              => 'HUMANA',
                    'identificaRuta'    => 'humana.*',
                    'permiso'           => 'Humana',
                    'icono'             => 'fa-solid fa-people-roof'
                ]);

        $m4=Menu::create([
                    'name'              => 'FACTURACIÓN',
                    'identificaRuta'    => 'facturacion.*',
                    'permiso'           => 'Facturacion',
                    'icono'             => 'fa-solid fa-file-invoice-dollar'
                ]);

        Menu::create([
                    'permiso'           => 'fa_empresas',
                    'ruta'              => 'facturacion.empresas',
                    'identificaRuta'    => 'facturacion.empresas',
                    'name'              => 'Empresas',
                    'icono'             => 'fa-solid fa-building text-gray-500',
                    'menu_id'           => $m4->id
                ]);

        Menu::create([
                    'permiso'           => 'fa_listas',
                    'ruta'              => 'facturacion.listas',
                    'identificaRuta'    => 'facturacion.listas',
                    'name'              => 'Listas Precio',
                    'icono'             => 'fa-solid fa-money-bill text-gray-500',
                    'menu_id'           => $m4->id
                ]);

        Menu::create([
                    'permiso'           => 'fa_productos',
                    'ruta'              => 'facturacion.productos',
                    'identificaRuta'    => 'facturacion.productos',
                    'name'              => 'Productos',
                    'icono'             => 'fa-solid fa-handshake text-gray-500',
                    'menu_id'           => $m4->id
                ]);

        Menu::create([
                    'permiso'           => 'fa_facturas',
                    'ruta'              => 'facturacion.facturas',
                    'identificaRuta'    => 'facturacion.facturas',
                    'name'              => 'Facturas',
                    'icono'             => 'fa-solid fa-file-invoice-dollar text-gray-500',
                    'menu_id'           => $m4->id
                ]);

        $m5=Menu::create([
                    'name'              => 'FINANCIERA',
                    'identificaRuta'    => 'financiera.*',
                    'permiso'           => 'Financiera',
                    'icono'             => 'fa-solid fa-chart-line'
                ]);

        Menu::create([
                    'permiso'           => 'fi_bancos',
                    'ruta'              => 'financiera.bancos',
                    'identificaRuta'    => 'financiera.bancos',
                    'name'              => 'Bancos',
                    'icono'             => 'fa-solid fa-piggy-bank text-gray-500',
                    'menu_id'           => $m5->id
                ]);

        Menu::create([
                    'permiso'           => 'fi_conceptos',
                    'ruta'              => 'financiera.conceptos',
                    'identificaRuta'    => 'financiera.conceptos',
                    'name'              => 'Conceptos',
                    'icono'             => 'fa-solid fa-coins text-gray-500',
                    'menu_id'           => $m5->id
                ]);

        Menu::create([
                    'permiso'           => 'fi_movimientos',
                    'ruta'              => 'financiera.movimientos',
                    'identificaRuta'    => 'financiera.movimientos',
                    'name'              => 'Movimientos',
                    'icono'             => 'fa-solid fa-sack-dollar text-gray-500',
                    'menu_id'           => $m5->id
                ]);

        $m6=Menu::create([
            'name'              => 'PESV',
            'identificaRuta'    => 'pesv.*',
            'permiso'           => 'PESV',
            'icono'             => 'fa-solid fa-truck-plane'
        ]); */
    }
}
