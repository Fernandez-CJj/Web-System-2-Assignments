<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::match(['get', 'post'], '/evaluation', function (Request $request) {
    return view('evaluation', [
        'name' => $request->name,
        'prelim' => $request->prelim,
        'midterm' => $request->midterm,
        'final' => $request->final,
        'submitted' => $request->isMethod('post')
    ]);
});
