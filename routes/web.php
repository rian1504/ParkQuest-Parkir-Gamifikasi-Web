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

// Route::get('/updateRank', function () {
//     \Illuminate\Support\Facades\Artisan::call('update:user-ranks');
//     echo 'Update rank berhasil';
// });

// Route::get('/resetMisi', function () {
//     \Illuminate\Support\Facades\Artisan::call('missions:reset-weekly');
//     echo 'Reset misi berhasil';
// });