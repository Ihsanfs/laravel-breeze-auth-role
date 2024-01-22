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
}
