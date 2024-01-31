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
     Route::get('/sekretaris', [Super\SuperadminController::class, 'sekretaris'])
            ->name('sekretaris');
            Route::get('/kabid', [Super\SuperadminController::class, 'kabid'])
            ->name('kabid');
            Route::get('/tps/sekretaris', [Super\SuperadminController::class, 'tps'])
            ->name('tps');
            Route::get('/tps/kabid', [Super\SuperadminController::class, 'tps_kabid'])
            ->name('tps_kabid');
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
