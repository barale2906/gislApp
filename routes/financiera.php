<?php

use Illuminate\Support\Facades\Route;

Route::get('/bancos', function () {
            return view('index.financiera.bancos');
        })->middleware('can:fi_bancos')->name('bancos');
