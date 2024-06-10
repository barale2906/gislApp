<?php

use Illuminate\Support\Facades\Route;

Route::get('/diligencias', function () {
            return view('index.diligencia.diligencias');
        })->middleware('can:di_diligencias')->name('diligencias');
