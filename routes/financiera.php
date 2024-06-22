<?php

use Illuminate\Support\Facades\Route;

Route::get('/bancos', function () {
            return view('index.financiera.bancos');
        })->middleware('can:fi_bancos')->name('bancos');

Route::get('/conceptos', function () {
            return view('index.financiera.conceptos');
        })->middleware('can:fi_conceptos')->name('conceptos');
