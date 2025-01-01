<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return redirect('admin');
});

// Route::get('/symlink', function () {
//     \Illuminate\Support\Facades\Artisan::call('storage:link');
//     echo 'Symlink berhasil';
// });