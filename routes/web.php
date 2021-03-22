<?php

use App\Http\Controllers\Csv;
use App\Http\Controllers\Payment;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::post('/upload-csv', [Csv::class, 'uploadCsvIntoDatabase']);

Route::get('/upload-completed', function () {
    return view('upload-completed');
});

Route::post('/view-csv', [Payment::class, 'showPaymentRecords']);

