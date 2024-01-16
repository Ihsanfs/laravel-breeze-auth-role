<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Creator;

use App\Http\Controllers\Admin;
use App\Http\Controllers\Super;

use App\Http\Controllers\Admin\StudentsController;
// use App\Http\Controllers\Super;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::middleware(['auth', 'verified', 'role:1'])
//     ->prefix('Creator')
//     ->name('Creator.')
//     ->group(function() {
//         Route::get('/timetable', [Creator\TimetableController::class, 'index'])
//             ->name('timetable');
//     });

Route::middleware(['auth', 'verified', 'role:1'])
    ->prefix('superadmin')
    ->name('superadmin.')
    ->group(function() {
        Route::get('/Dashboard', [Super\SuperadminController::class, 'index'])
            ->name('dashboard');
     Route::get('/kategori', [Super\SuperadminController::class, 'kategori'])
            ->name('kategori');
    });

Route::middleware(['auth', 'verified', 'role:2'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function() {
        Route::get('/Dashboard', [Admin\StudentsController::class, 'index'])
            ->name('dashboard');
            // Route::get('/students', [Admin\StudentsController::class, 'index'])
            // ->name('students');
    });



require __DIR__.'/auth.php';
