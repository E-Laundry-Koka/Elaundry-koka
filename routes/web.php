<?php

use Illuminate\Support\Facades\Route;

//home
Route::get('/', function () {
    return view('index');
});

// login
Route::get('/login', function () {
    return view('login');
});

//register
Route::get('/signup', function () {
    return view('register');
});
