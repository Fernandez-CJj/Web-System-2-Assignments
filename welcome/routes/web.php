<?php

use App\Http\Controllers\PreController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', [PreController::class, 'index']);
