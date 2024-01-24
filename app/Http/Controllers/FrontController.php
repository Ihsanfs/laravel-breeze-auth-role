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
        $halaman = Halaman::leftjoin('menu', 'halaman.menu_id', '=', 'menu.id')
        ->select('halaman.id', 'halaman.nama', 'halaman.page_halaman')
        ->where('halaman.page_halaman', '>', 0)
        ->orderBy('halaman.page_halaman', 'ASC')
        ->get();


       return view('front.index',compact('halaman'));
    }
}
