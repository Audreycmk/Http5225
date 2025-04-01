<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('students', StudentController::class);
// Route::get('/students', function () {
//     return view('students.index');
// });

// Route::get('/students', function () {
//     return view('students.update');
// });
