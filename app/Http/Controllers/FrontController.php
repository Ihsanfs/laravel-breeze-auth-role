<?php

namespace App\Http\Controllers;

use App\Models\artikel;
use App\Models\Gallery;
use App\Models\halaman;
use App\Models\instansi;
use App\Models\kategori;
use App\Models\menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FrontController extends Controller
{
    public function index($slug)
    {

        //halaman urut
        $halaman = Halaman::leftJoin('menu', 'halaman.menu_id', '=', 'menu.id')
            ->select('menu.*', 'halaman.*')
            ->where('halaman.page_halaman', '>', 0)
            ->orderBy('halaman.page_halaman', 'ASC')
            ->get();

        // Mengelompokkan berdasarkan menu_id
        $grouphalaman = $halaman->groupBy('menu_id');

        $menu = Menu::all();

        $artikel = artikel::with('kategori','users')->where('slug', $slug)->first();
        $artikel->increment('views');
        $berita_baru = artikel::latest()->get();

        $berita_populer = Artikel::orderBy('views', 'desc')->get();

        return view('front.detail_berita', compact('artikel', 'halaman', 'berita_baru', 'menu', 'grouphalaman', 'berita_populer'));
    }

    public function beranda()
    {

        //halaman urut
        $halaman = Halaman::leftJoin('menu', 'halaman.menu_id', '=', 'menu.id')
            ->select('menu.*', 'halaman.*')
            ->where('halaman.page_halaman', '>', 0)
            ->orderBy('halaman.page_halaman', 'ASC')
            ->get();

        // Mengelompokkan berdasarkan menu_id
        $grouphalaman = $halaman->groupBy('menu_id');
        $berita_populer = Artikel::orderBy('views', 'desc')->take(4)->get();
        $menu = Menu::all();
        //galery\
        $instansi =instansi::first();
        $galeri = Gallery::all();
        $berita = artikel::latest()->take(10)->get();

        return view('front.beranda', compact('halaman', 'berita', 'menu', 'grouphalaman', 'galeri','berita_populer','instansi'));
    }

    public function halaman($slug)
    {
        //halaman urut
        $halaman = Halaman::leftJoin('menu', 'halaman.menu_id', '=', 'menu.id')
            ->select('menu.*', 'halaman.*')
            ->where('halaman.page_halaman', '>', 0)
            ->orderBy('halaman.page_halaman', 'ASC')
            ->get();

        // Mengelompokkan berdasarkan menu_id
        $grouphalaman = $halaman->groupBy('menu_id');
        $menu = Menu::all();
        $halaman_detail = Halaman::with('author_halaman')->where('slug', $slug)->first();

        // hitung perclick halaman
        if (isset($halaman_detail->view)) {
            $halaman_detail->increment('view');
        }



        return view('front.halaman', compact('halaman_detail', 'halaman', 'menu', 'grouphalaman'));
    }

    public function search_berita(Request $request)
    {

        //halaman urut
        $halaman = Halaman::leftJoin('menu', 'halaman.menu_id', '=', 'menu.id')
            ->select('menu.*', 'halaman.*')
            ->where('halaman.page_halaman', '>', 0)
            ->orderBy('halaman.page_halaman', 'ASC')
            ->get();

        // Mengelompokkan berdasarkan menu_id
        $grouphalaman = $halaman->groupBy('menu_id');

        $menu = Menu::all();
        $berita_baru = artikel::latest()->get();

        $berita_populer = Artikel::orderBy('views', 'desc')->get();
        $cari = $request->cari_berita;
        $berita = Artikel::where('judul', 'like', '%' . $cari . '%')
            ->orWhere('slug', 'like', '%' . $cari . '%')
            ->orWhere('body', 'like', '%' . $cari . '%')
            ->paginate(20);

        return view('front.berita_search', compact('berita', 'berita_baru', 'berita_populer', 'menu', 'grouphalaman',));
    }

    public function berita_lengkap()
    {
        //halaman urut
        $halaman = Halaman::leftJoin('menu', 'halaman.menu_id', '=', 'menu.id')
            ->select('menu.*', 'halaman.*')
            ->where('halaman.page_halaman', '>', 0)
            ->orderBy('halaman.page_halaman', 'ASC')
            ->get();

        // Mengelompokkan berdasarkan menu_id
        $grouphalaman = $halaman->groupBy('menu_id');

        $menu = Menu::all();

        $berita = artikel::latest()->paginate(20);
        $berita_baru = artikel::latest()->get();
        $kategori = kategori::all();
        $berita_populer = Artikel::orderBy('views', 'desc')->get();
        return view('front.berita_selengkapnya', compact('berita', 'menu', 'grouphalaman', 'berita_baru', 'berita_populer','kategori'));
    }

    public function kategori_tampil($category){
        $kategori = kategori::join('artikels', 'kategori.id', '=', 'artikels.kategori_id')
        ->where('kategori.nama_kategori', $category)
        ->get();
        dd($kategori);
    }
}
