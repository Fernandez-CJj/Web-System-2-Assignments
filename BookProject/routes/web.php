<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/books/create');

Route::resource('books', BookController::class)->except(['show']);
