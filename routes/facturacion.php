<?php

use Illuminate\Support\Facades\Route;

Route::get('/empresas', function () {
            return view('index.facturacion.empresas');
        })->middleware('can:fa_empresas')->name('empresas');

Route::get('/listas', function () {
            return view('index.facturacion.listas');
        })->middleware('can:fa_listas')->name('listas');

Route::get('/productos', function () {
            return view('index.facturacion.productos');
        })->middleware('can:fa_productos')->name('productos');

Route::get('/facturas', function () {
            return view('index.facturacion.facturas');
        })->middleware('can:fa_facturas')->name('facturas');

