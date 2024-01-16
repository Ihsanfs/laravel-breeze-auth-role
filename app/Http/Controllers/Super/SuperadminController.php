<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuperadminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function kategori(){
        return view('form.kategori.index');
    }

    public function kategori_add(){
        return view('form.kategori.create');
    }
    public function berita (){
        return view('form.berita.index');
    }

    public function berita_add (){
        return view('form.berita.create');
    }

    public function slider(){
        return view('form.slide.index');

    }

    public function slider_add(){
        return view('form.slide.create');

    }
}
