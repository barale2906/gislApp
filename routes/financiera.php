<?php

use Illuminate\Support\Facades\Route;

Route::get('/bancos', function () {
            return view('index.financiera.bancos');
        })->middleware('can:fi_bancos')->name('bancos');

Route::get('/conceptos', function () {
            return view('index.financiera.conceptos');
        })->middleware('can:fi_conceptos')->name('conceptos');

Route::get('/movimientos', function () {
            return view('index.financiera.movimientos');
        })->middleware('can:fi_movimientos')->name('movimientos');

Route::get('/carteras', function () {
            return view('index.financiera.carteras');
        })->middleware('can:fi_carteras')->name('carteras');
