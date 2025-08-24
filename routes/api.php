<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiagnosticoController;

Route::post('/diagnostico', [DiagnosticoController::class, 'store']);
