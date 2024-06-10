<?php

use Illuminate\Support\Facades\Route;

Route::get('/empresas', function () {
            return view('index.facturacion.empresas');
        })->middleware('can:co_users')->name('empresas');
