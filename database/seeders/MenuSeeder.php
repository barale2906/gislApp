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
                    'icono'             => 'fa-solid fa-file-invoice-dollar  text-gray-500'
                ]);

        Menu::create([
                    'permiso'           => 'fa_empresas',
                    'ruta'              => 'facturacion.empresas',
                    'identificaRuta'    => 'facturacion.empresas',
                    'name'              => 'Empresas',
                    'icono'             => 'fa-solid fa-building',
                    'menu_id'           => $m4->id
                ]);

        Menu::create([
                    'permiso'           => 'fa_listas',
                    'ruta'              => 'facturacion.listas',
                    'identificaRuta'    => 'facturacion.listas',
                    'name'              => 'Listas Precio',
                    'icono'             => 'fa-solid fa-money-bill',
                    'menu_id'           => $m4->id
                ]);

        Menu::create([
                    'permiso'           => 'fa_productos',
                    'ruta'              => 'facturacion.productos',
                    'identificaRuta'    => 'facturacion.productos',
                    'name'              => 'Productos',
                    'icono'             => 'fa-solid fa-handshake',
                    'menu_id'           => $m4->id
                ]);

        Menu::create([
                    'permiso'           => 'fa_facturas',
                    'ruta'              => 'facturacion.facturas',
                    'identificaRuta'    => 'facturacion.facturas',
                    'name'              => 'Facturas',
                    'icono'             => 'fa-solid fa-file-invoice-dollar',
                    'menu_id'           => $m4->id
                ]);

        $m5=Menu::create([
                    'name'              => 'FINANCIERA',
                    'identificaRuta'    => 'financiera.*',
                    'permiso'           => 'Financiera',
                    'icono'             => 'fa-solid fa-chart-line'
                ]);

        $m6=Menu::create([
            'name'              => 'PESV',
            'identificaRuta'    => 'pesv.*',
            'permiso'           => 'PESV',
            'icono'             => 'fa-solid fa-truck-plane'
        ]);
    }
}
