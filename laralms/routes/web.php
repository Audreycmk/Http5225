<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/students', function () {
//     return view('students.index');
// });

// Route::get('/students', function () {
//     return view('students.update');
// });

Route::resource('students', StudentController::class);