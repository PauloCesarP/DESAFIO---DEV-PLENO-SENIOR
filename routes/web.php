<?php

use App\Http\Controllers\XmlReaderController;
use Illuminate\Support\Facades\Route;


//ROUTES OF INDEX VIEW
Route::get('/', [XmlReaderController::class, 'index'])->name('index');
Route::post('/', [XmlReaderController::class, 'readXml'])->name('readXml');
