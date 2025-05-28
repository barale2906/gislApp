<?php

use Illuminate\Support\Facades\Route;

Route::get('/contratos', function () {
            return view('index.humana.contratos');
        })->middleware('can:hu_contratos')->name('contratos');

Route::get('/adicionales', function () {
            return view('index.humana.adicionales');
        })->middleware('can:hu_adicionales')->name('adicionales');

Route::get('/salarios', function () {
            return view('index.humana.salarios');
        })->middleware('can:hu_salarios')->name('salarios');
