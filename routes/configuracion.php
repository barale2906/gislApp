<?php

use Illuminate\Support\Facades\Route;

Route::get('/users', function () {
            return view('index.configuracion.users');
        })->middleware('can:co_users')->name('users');

Route::get('/roles', function () {
            return view('index.configuracion.roles');
        })->middleware('can:co_rols')->name('roles');

Route::get('/ciudades', function () {
            return view('index.configuracion.ciudades');
        })->middleware('can:co_ciudads')->name('ciudades');

Route::get('/areas', function () {
            return view('index.configuracion.areas');
        })->middleware('can:co_areas')->name('areas');

Route::get('/perfil', function () {
            return view('index.configuracion.perfil');
        })->name('perfil');
