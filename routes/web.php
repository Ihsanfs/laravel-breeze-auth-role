<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Creator;

use App\Http\Controllers\Admin;
use App\Http\Controllers\Super;

use App\Http\Controllers\Admin\StudentsController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\MenuController;

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

Route::middleware(['web'])->group(function () {
    // Route::get('/', function () {
    //     return view('welcome');
    // });

    Route::get('/page/{slug}', [FrontController::class, 'index']);
    Route::get('/', [FrontController::class, 'urutan'])->name('urut');

});


Route::middleware(['auth', 'verified', 'role:1'])
    ->prefix('superadmin')
    ->name('superadmin.')
    ->group(function() {
        Route::get('/Dashboard', [Super\SuperadminController::class, 'index'])
            ->name('dashboard');


            //kategori
            Route::get('/kategori', [Super\SuperadminController::class, 'kategori'])
            ->name('kategori');
            Route::get('/kategori/create', [Super\SuperadminController::class, 'kategori_add'])
            ->name('kategori_add');
            Route::post('/kategori/store', [Super\SuperadminController::class, 'kategori_store'])
            ->name('kategori_store');
            Route::get('/kategori/edit/{id}', [Super\SuperadminController::class, 'kategori_show'])
            ->name('edit_kategori');
            Route::delete('/kategori/hapus/{id}', [Super\SuperadminController::class, 'kategori_hapus'])
            ->name('hapus_kategori');
            Route::put('/kategori/update/{id}', [Super\SuperadminController::class, 'kategori_update'])
            ->name('kategori_update');


            //berita
            Route::get('/berita', [Super\SuperadminController::class, 'berita'])
            ->name('berita');
            Route::get('/berita/search', [Super\SuperadminController::class, 'berita_search'])
            ->name('berita_search');
            Route::get('/berita/search/{slug}', [Super\SuperadminController::class, 'berita_detail'])
            ->name('berita_detail');
            Route::post('/berita/store', [Super\SuperadminController::class, 'berita_store'])
            ->name('berita_store');
            Route::get('/berita/{id}/edit', [Super\SuperadminController::class, 'berita_edit'])
            ->name('berita_edit');
            Route::get('/berita/create', [Super\SuperadminController::class, 'berita_add'])
            ->name('berita_add');
            Route::put('/berita/{id}/update', [Super\SuperadminController::class, 'berita_update'])
            ->name('berita_update');
            Route::delete('/berita/{id}/delete', [Super\SuperadminController::class, 'berita_delete'])
            ->name('berita_delete');



            //slide video
            Route::get('/video', [Super\SlideController::class, 'index'])
            ->name('video');
            Route::get('/video/create', [Super\SlideController::class, 'create'])
            ->name('video_add');
            Route::post('/video/store', [Super\SlideController::class, 'store'])
            ->name('video_store');
            Route::get('/video/{id}/edit', [Super\SlideController::class, 'edit'])
            ->name('video_edit');
            Route::put('/video/{id}/update', [Super\SlideController::class, 'update'])
            ->name('video_update');
            Route::delete('/video/{id}/delete', [Super\SlideController::class, 'destroy'])
            ->name('video_delete');



            //gallery
            Route::get('/gallery', [Super\FotoController::class, 'index'])
            ->name('galery');
            Route::get('/gallery/create', [Super\FotoController::class, 'create'])
            ->name('galery_create');
            Route::get('/gallery/{id}/edit', [Super\FotoController::class, 'edit'])
            ->name('galery_edit');
            Route::post('/gallery/store', [Super\FotoController::class, 'store'])
            ->name('galery_store');
            Route::put('/gallery/{id}/update', [Super\FotoController::class, 'update'])
            ->name('galery_update');
            Route::delete('/gallery/{id}/delete', [Super\FotoController::class, 'destroy'])
            ->name('galery_destroy');

            //instansi
            Route::get('/instansi', [Super\InstansiController::class, 'index'])
            ->name('instansi');
            Route::put('/instansi/{id}/update', [Super\InstansiController::class, 'update'])
            ->name('instansi_update');
            Route::get('/instansi/create', [Super\InstansiController::class, 'create'])
            ->name('instansi_create');

            Route::post('/instansi/store', [Super\InstansiController::class, 'store'])
            ->name('instansi_store');

            Route::get('/instansi/{id}/edit', [Super\InstansiController::class, 'edit'])
            ->name('instansi_edit');




            ///users
            Route::get('/users/profile', [Super\UsersController::class, 'index'])
            ->name('users');
            Route::get('/users/all', [Super\UsersController::class, 'tampil_user'])
            ->name('users_all');
            Route::delete('/users/{id}/delete', [Super\UsersController::class, 'hapus_user'])
            ->name('users_hapus');
            Route::get('/users/create', [Super\UsersController::class, 'create'])
            ->name('users_create');
            Route::post('/users/store', [Super\UsersController::class, 'store'])
            ->name('users_store');
            Route::put('/users/{id}/update', [Super\UsersController::class, 'update'])
            ->name('users_update');
            Route::get('/users/status/{id}', [Super\UsersController::class, 'status'])
            ->name('users_status');
            Route::get('/users/edit_user/{id}', [Super\UsersController::class, 'edit_user'])
            ->name('users_edit_data');
            Route::put('/users/edit_user/{id}/update', [Super\UsersController::class, 'update_user'])
            ->name('users_edit_data_update');

            Route::get('/users/password', [Super\UsersController::class, 'password'])
            ->name('users_password');
            Route::put('/users/password/{id}', [Super\UsersController::class, 'password_update'])
            ->name('users_password_update');
            Route::get('/users/{id}/update', [Super\UsersController::class, 'edit'])
            ->name('users_edit');

            //halaman
            Route::get('/halaman', [Super\HalamanController::class, 'index'])
            ->name('halaman');
            Route::post('/halaman/store', [Super\HalamanController::class, 'store'])
            ->name('halaman_store');
            Route::get('/halaman/{id}/edit', [Super\HalamanController::class, 'edit'])
            ->name('halaman_edit');
            Route::put('/halaman/update/{id}', [Super\HalamanController::class, 'update'])
            ->name('halaman_update');
            Route::delete('/halaman/destroy/{id}', [Super\HalamanController::class, 'destroy'])
            ->name('halaman_delete');
            Route::get('/halaman/create', [Super\HalamanController::class, 'create'])
            ->name('halaman_create');

            //menu
            Route::get('/menu', [MenuController::class, 'index'])
            ->name('menu');
            Route::get('/menu/create', [MenuController::class, 'create'])
            ->name('menu_create');

            Route::get('/menu/{id}/edit', [MenuController::class, 'edit'])
            ->name('menu_edit');
            Route::put('/menu/update/{id}', [MenuController::class, 'update'])
            ->name('menu_update');
            Route::delete('/menu/destroy/{id}', [MenuController::class, 'index'])
            ->name('menu_delete');
            Route::post('/menu/store', [MenuController::class, 'store'])
            ->name('menu_store');

    });

Route::middleware(['auth', 'verified', 'role:2'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function() {
        Route::get('/Dashboard', [Super\SuperadminController::class, 'index'])
        ->name('dashboard');


        //kategori
        Route::get('/kategori', [Super\SuperadminController::class, 'kategori'])
        ->name('kategori');
        Route::get('/kategori/create', [Super\SuperadminController::class, 'kategori_add'])
        ->name('kategori_add');
        Route::post('/kategori/store', [Super\SuperadminController::class, 'kategori_store'])
        ->name('kategori_store');
        Route::get('/kategori/edit/{id}', [Super\SuperadminController::class, 'kategori_show'])
        ->name('edit_kategori');
        Route::delete('/kategori/hapus/{id}', [Super\SuperadminController::class, 'kategori_hapus'])
        ->name('hapus_kategori');
        Route::put('/kategori/update/{id}', [Super\SuperadminController::class, 'kategori_update'])
        ->name('kategori_update');


        //berita
        Route::get('/berita', [Super\SuperadminController::class, 'berita'])
        ->name('berita');
        Route::post('/berita/store', [Super\SuperadminController::class, 'berita_store'])
        ->name('berita_store');
        Route::get('/berita/{id}/edit', [Super\SuperadminController::class, 'berita_edit'])
        ->name('berita_edit');
        Route::get('/berita/create', [Super\SuperadminController::class, 'berita_add'])
        ->name('berita_add');
        Route::put('/berita/{id}/update', [Super\SuperadminController::class, 'berita_update'])
        ->name('berita_update');
        Route::delete('/berita/{id}/delete', [Super\SuperadminController::class, 'berita_delete'])
        ->name('berita_delete');



        //slide video
        Route::get('/video', [Super\SlideController::class, 'index'])
        ->name('video');
        Route::get('/video/create', [Super\SlideController::class, 'create'])
        ->name('video_add');
        Route::post('/video/store', [Super\SlideController::class, 'store'])
        ->name('video_store');
        Route::get('/video/{id}/edit', [Super\SlideController::class, 'edit'])
        ->name('video_edit');
        Route::put('/video/{id}/update', [Super\SlideController::class, 'update'])
        ->name('video_update');
        Route::delete('/video/{id}/delete', [Super\SlideController::class, 'destroy'])
        ->name('video_delete');



        //gallery
        Route::get('/gallery', [Super\FotoController::class, 'index'])
        ->name('galery');
        Route::get('/gallery/create', [Super\FotoController::class, 'create'])
        ->name('galery_create');
        Route::get('/gallery/{id}/edit', [Super\FotoController::class, 'edit'])
        ->name('galery_edit');
        Route::post('/gallery/store', [Super\FotoController::class, 'store'])
        ->name('galery_store');
        Route::put('/gallery/{id}/update', [Super\FotoController::class, 'update'])
        ->name('galery_update');
        Route::delete('/gallery/{id}/delete', [Super\FotoController::class, 'destroy'])
        ->name('galery_destroy');

        //instansi
        Route::get('/instansi', [Super\InstansiController::class, 'index'])
        ->name('instansi');
        Route::put('/instansi/{id}/update', [Super\InstansiController::class, 'update'])
        ->name('instansi_update');
        Route::get('/instansi/create', [Super\InstansiController::class, 'create'])
        ->name('instansi_create');

        Route::post('/instansi/store', [Super\InstansiController::class, 'store'])
        ->name('instansi_store');

        Route::get('/instansi/{id}/edit', [Super\InstansiController::class, 'edit'])
        ->name('instansi_edit');




        ///users
        Route::get('/users/profile', [Super\UsersController::class, 'index'])
        ->name('users');
        Route::delete('/users/{id}/delete', [Super\UsersController::class, 'hapus_user'])
        ->name('users_hapus');
        Route::get('/users/create', [Super\UsersController::class, 'create'])
        ->name('users_create');
        Route::post('/users/store', [Super\UsersController::class, 'store'])
        ->name('users_store');
        Route::put('/users/{id}/update', [Super\UsersController::class, 'update'])
        ->name('users_update');

        Route::get('/users/status/{id}', [Super\UsersController::class, 'status'])
        ->name('users_status');


        Route::get('/users/password', [Super\UsersController::class, 'password'])
        ->name('users_password');
        Route::put('/users/password/{id}', [Super\UsersController::class, 'password_update'])
        ->name('users_password_update');
        Route::get('/users/{id}/update', [Super\UsersController::class, 'edit'])
        ->name('users_edit');

        //halaman
        Route::get('/halaman', [Super\HalamanController::class, 'index'])
        ->name('halaman');
        Route::post('/halaman/store', [Super\HalamanController::class, 'store'])
        ->name('halaman_store');
        Route::get('/halaman/{id}/edit', [Super\HalamanController::class, 'edit'])
        ->name('halaman_edit');
        Route::put('/halaman/update/{id}', [Super\HalamanController::class, 'update'])
        ->name('halaman_update');
        Route::delete('/halaman/destroy/{id}', [Super\HalamanController::class, 'destroy'])
        ->name('halaman_delete');
        Route::get('/halaman/create', [Super\HalamanController::class, 'create'])
        ->name('halaman_create');

        //menu
        Route::get('/menu', [MenuController::class, 'index'])
        ->name('menu');
        Route::get('/menu/create', [MenuController::class, 'create'])
        ->name('menu_create');

        Route::get('/menu/{id}/edit', [MenuController::class, 'edit'])
        ->name('menu_edit');
        Route::put('/menu/update/{id}', [MenuController::class, 'update'])
        ->name('menu_update');
        Route::delete('/menu/destroy/{id}', [MenuController::class, 'index'])
        ->name('menu_delete');
        Route::post('/menu/store', [MenuController::class, 'store'])
        ->name('menu_store');
    });



require __DIR__.'/auth.php';
