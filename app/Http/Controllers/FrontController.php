<?php

namespace App\Http\Controllers;

use App\Models\artikel;
use App\Models\halaman;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index($slug){



        $artikel = halaman::with('author_halaman')->where('slug', $slug)->first();

        if ($artikel) {
            $artikel->increment('view');

        }

        dd($artikel);
    }

    public function urutan(){

        //halaman urut
        $halaman = halaman::leftjoin('menu', 'halaman.menu_id', '=', 'menu.id')->select('halaman.id','halaman.nama','halaman.page_halaman')
        ->orderBy('page_halaman', 'ASC')
        ->get();

       return view('front.index',compact('halaman'));
    }
}
