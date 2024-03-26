<?php

namespace App\Http\Controllers;

use App\Models\album;
use App\Models\artikel;
use App\Models\artikeltag;
use App\Models\Gallery;
use App\Models\halaman;
use App\Models\instansi;
use App\Models\kategori;
use App\Models\kategori_tag;
use App\Models\menu;
use App\Models\slider;
use App\Models\tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FrontController extends Controller
{

    public function beranda()
    {

        //halaman urut
        $halaman = Halaman::leftJoin('menu', 'halaman.menu_id', '=', 'menu.id')
            ->where('menu.is_active', 1)
            ->where('halaman.is_active',1)
            ->where('halaman.page_halaman', '>', 0)
            ->select('menu.*', 'halaman.*')
            ->orderBy('halaman.page_halaman', 'ASC')
            ->get();

        $grouphalaman = $halaman->groupBy('menu_id');

        $berita_populer = Artikel::orderBy('views', 'desc')->take(4)->get();
        $menu = Menu::where('is_active', 1)->get();
        //galery\
        $instansi = instansi::first();
        $galeri = album::all();
        $berita = Artikel::latest()->take(10)->get();

        $berita_terbaru = Artikel::orderByDesc('created_at')->take(6)->get();

        $slidertampil = slider::all();
        return view('front.beranda', compact('halaman', 'berita', 'menu', 'grouphalaman', 'galeri', 'berita_populer', 'instansi', 'berita_terbaru','slidertampil'));
    }
    public function index($slug)
    {

        //halaman urut
        $halaman = Halaman::leftJoin('menu', 'halaman.menu_id', '=', 'menu.id')
        ->where('menu.is_active', 1)
        ->where('halaman.is_active',1)
        ->where('halaman.page_halaman', '>', 0)
        ->select('menu.*', 'halaman.*')
        ->orderBy('halaman.page_halaman', 'ASC')
        ->get();
        $grouphalaman = $halaman->groupBy('menu_id');

        $menu = Menu::all();
        $artikel = Artikel::with('users')
            ->leftJoin('kategori_tag', 'kategori_tag.artikel_id', '=', 'artikels.id')
            ->leftJoin('kategori', 'kategori.id', '=', 'kategori_tag.kategori_id')
            ->leftjoin('artikels_tag', 'artikels_tag.artikel_id', '=', 'artikels.id')
            ->leftjoin('tag', 'tag.id', '=', 'artikels_tag.tag_id')
            ->select('artikels.*', 'kategori.nama_kategori', 'tag.nama_tag', 'tag.slug as slugtag')
            ->where('artikels.slug', $slug)
            ->first();

        $kat_lop = kategori_tag::query()->join('kategori', 'kategori.id', '=', 'kategori_tag.kategori_id')->whereIn('artikel_id', [$artikel->id])->get();

        // foreach($kat_lop as $i){
        //     echo $i->nama_kategori;
        // }

        $tag_lop = artikeltag::query()->join(
            'tag',
            'tag.id',
            '=',
            'artikels_tag.tag_id'
        )->whereIn('artikel_id', [$artikel->id])->get();


        // foreach($tag_lop as $i){
        //     echo $i->nama_tag;
        // }
        if ($artikel) {
            $artikel->increment('views');
        }

        $berita_baru = artikel::latest()->take(5)->get();

        $berita_populer = Artikel::orderBy('views', 'desc')->take(5)->get();

        return view('front.detail_berita', compact('artikel', 'tag_lop', 'kat_lop', 'halaman', 'berita_baru', 'menu', 'grouphalaman', 'berita_populer', 'slug'));
    }



    public function halaman($slug)
    {
        //halaman urut
        $halaman = Halaman::leftJoin('menu', 'halaman.menu_id', '=', 'menu.id')
        ->where('menu.is_active', 1)
        ->where('halaman.is_active',1)
        ->where('halaman.page_halaman', '>', 0)
        ->select('menu.*', 'halaman.*')
        ->orderBy('halaman.page_halaman', 'ASC')
        ->get();

        // Mengelompokkan berdasarkan menu_id
        $grouphalaman = $halaman->groupBy('menu_id');
        $menu = Menu::all();
        $halaman_detail = Halaman::with('author_halaman')->where('slug', $slug)->first();

      
        if (!$halaman_detail) {
            $halaman_detail = Menu::where('slug', $slug)->first();
        }
        // dd($halaman_detail);

        // hitung perclick halaman
        if (isset($halaman_detail->view)) {
            $halaman_detail->increment('view');
        }



        return view('front.halaman', compact('halaman_detail', 'halaman', 'menu', 'grouphalaman', 'slug'));
    }

    public function search_berita(Request $request)
    {

        //halaman urut
        $halaman = Halaman::leftJoin('menu', 'halaman.menu_id', '=', 'menu.id')
        ->where('menu.is_active', 1)
        ->where('halaman.is_active',1)
        ->where('halaman.page_halaman', '>', 0)
        ->select('menu.*', 'halaman.*')
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
        ->where('menu.is_active', 1)
        ->where('halaman.is_active',1)
        ->where('halaman.page_halaman', '>', 0)
        ->select('menu.*', 'halaman.*')
        ->orderBy('halaman.page_halaman', 'ASC')
        ->get();

        // Mengelompokkan berdasarkan menu_id
        $grouphalaman = $halaman->groupBy('menu_id');

        $menu = Menu::all();

        $berita = artikel::latest()->paginate(20);
        $berita_baru = artikel::latest()->get();
        $kategori = kategori::all();
        $berita_populer = Artikel::orderBy('views', 'desc')->get();
        return view('front.berita_selengkapnya', compact('berita', 'menu', 'grouphalaman', 'berita_baru', 'berita_populer', 'kategori'));
    }

    public function kategori_tampil($category)
    {
        //halaman urut
        $halaman = Halaman::leftJoin('menu', 'halaman.menu_id', '=', 'menu.id')
        ->where('menu.is_active', 1)
        ->where('halaman.is_active',1)
        ->where('halaman.page_halaman', '>', 0)
        ->select('menu.*', 'halaman.*')
        ->orderBy('halaman.page_halaman', 'ASC')
        ->get();

        // Mengelompokkan berdasarkan menu_id
        $grouphalaman = $halaman->groupBy('menu_id');

        $menu = Menu::all();

        $berita = artikel::latest()->paginate(20);
        $berita_baru = artikel::latest()->get();
        //    $kategori = kategori::all();
        $berita_populer = Artikel::orderBy('views', 'desc')->get();
        // Mengambil data kategori dari artikels dengan penghapusan duplikasi berdasarkan artikel ID
        $kategori = kategori::join('kategori_tag', 'kategori_tag.kategori_id', '=', 'kategori.id')
            ->join('artikels as a', 'a.id', '=', 'kategori_tag.artikel_id')
            ->leftjoin('users', 'users.id', '=', 'a.user_id')
            ->where('kategori.slug', $category)
            ->select('a.*', 'kategori.nama_kategori', 'kategori.slug', 'users.name')
            ->distinct('a.id')
            ->get();


        $artikelid = $kategori->pluck('id')->toArray();


        $kategori_data = kategori::join('kategori_tag', 'kategori_tag.kategori_id', '=', 'kategori.id')
            ->join('artikels as a', 'a.id', '=', 'kategori_tag.artikel_id')
            ->where('kategori_tag.artikel_id', $artikelid)
            ->select('a.*', 'kategori.nama_kategori', 'kategori.slug')
            ->distinct('a.id')
            ->get();
        // kategori_tag berdasarkan artikel
        $kat_lop = kategori_tag::join('kategori', 'kategori.id', '=', 'kategori_tag.kategori_id')
            ->whereIn('artikel_id', $artikelid)

            ->get();

        $groupKatLop = [];
        foreach ($kat_lop as $d) {
            $groupKatLop[$d->artikel_id][] = $d->nama_kategori;
        }

        //tampil berdasarkan kategori
        $tag_lop = artikeltag::query()
            ->leftjoin('tag', 'tag.id', '=', 'artikels_tag.tag_id')
            ->whereIn('artikels_tag.artikel_id', $artikelid)
            ->get();

        //tag group kategori
        $tag_cek = artikeltag::query()
            ->leftjoin('tag', 'tag.id', '=', 'artikels_tag.tag_id')
            ->whereIn('artikels_tag.artikel_id', $artikelid)
            ->select('artikels_tag.tag_id', 'tag.nama_tag', 'tag.slug')->groupBy('artikels_tag.tag_id', 'tag.nama_tag', 'tag.slug')
            ->get();



        $grouptagLop = [];
        foreach ($tag_lop as $d) {
            $grouptagLop[$d->artikel_id][] = $d->nama_tag;
        }
        $categories = Kategori::pluck('slug', 'nama_kategori');
        $tags = tag::pluck('slug', 'nama_tag');



        $kategori_group = $kategori->groupBy('nama_kategori');
        // dd($kategori);
        return view('front.kategori', compact('berita', 'kategori_data', 'categories', 'tags', 'menu', 'kat_lop', 'tag_lop', 'tag_cek', 'grouptagLop', 'groupKatLop', 'grouphalaman', 'kategori_group', 'berita_baru', 'berita_populer', 'kategori', 'category'));
    }

    public function tag_tampil($tag)
    {
        //halaman urut
        $halaman = Halaman::leftJoin('menu', 'halaman.menu_id', '=', 'menu.id')
        ->where('menu.is_active', 1)
        ->where('halaman.is_active',1)
        ->where('halaman.page_halaman', '>', 0)
        ->select('menu.*', 'halaman.*')
        ->orderBy('halaman.page_halaman', 'ASC')
        ->get();

        // Mengelompokkan berdasarkan menu_id
        $grouphalaman = $halaman->groupBy('menu_id');
        $menu = Menu::all();

        $berita = artikel::latest()->paginate(20);
        $berita_baru = artikel::latest()->take(5)->get();
        //    $kategori = kategori::all();
        $berita_populer = Artikel::orderBy('views', 'desc')->get();

        $tag_data = tag::join('artikels_tag', 'artikels_tag.tag_id', '=', 'tag.id')
            ->join('artikels as c', 'artikels_tag.artikel_id', '=', 'c.id')
            ->join('users', 'users.id', '=', 'c.user_id')
            ->where('tag.slug', $tag)
            ->select('c.*', 'tag.nama_tag', 'users.name', 'tag.slug')
            ->distinct('c.id')
            ->get();
        // dd($tag_data);



        $tagid = $tag_data->pluck('id')->toArray();


        $kategori = kategori::join('kategori_tag', 'kategori_tag.kategori_id', '=', 'kategori.id')
            ->join('artikels as a', 'a.id', '=', 'kategori_tag.artikel_id')
            ->where('kategori_tag.artikel_id', $tagid)
            ->select('a.*', 'kategori.nama_kategori', 'kategori.slug')
            ->distinct('a.id')
            ->get();
        // dd($kategori);
        $kat_lop = kategori_tag::join('kategori', 'kategori.id', '=', 'kategori_tag.kategori_id')
            ->whereIn('artikel_id', $tagid)
            ->get();

        $groupKatLop = [];
        foreach ($kat_lop as $d) {
            $groupKatLop[$d->artikel_id][] = $d->nama_kategori;
        }

        //tampil berdasarkan kategori
        $tag_lop = artikeltag::query()
            ->leftjoin('tag', 'tag.id', '=', 'artikels_tag.tag_id')
            ->whereIn('artikels_tag.artikel_id', $tagid)
            ->get();

        //tag group kategori
        $tag_cek = artikeltag::query()
            ->leftjoin('tag', 'tag.id', '=', 'artikels_tag.tag_id')
            ->whereIn('artikels_tag.artikel_id', $tagid)
            ->select('artikels_tag.tag_id', 'tag.nama_tag', 'tag.slug')->groupBy('artikels_tag.tag_id', 'tag.nama_tag', 'tag.slug')
            ->get();

        $grouptagLop = [];
        foreach ($tag_lop as $d) {
            $grouptagLop[$d->artikel_id][] = $d->nama_tag;
        }

        $categories = Kategori::pluck('slug', 'nama_kategori');
        $tags = tag::pluck('slug', 'nama_tag');
        return view('front.detail_tag', compact('tag', 'kategori', 'grouptagLop', 'tags', 'categories', 'tag_data', 'tag_cek', 'tag_lop', 'groupKatLop', 'halaman', 'grouphalaman', 'menu', 'berita', 'berita_baru', 'berita_populer'));
    }


    public function halaman_menu($slug)
    {
        //halaman urut
        $halaman = Halaman::leftJoin('menu', 'halaman.menu_id', '=', 'menu.id')
        ->where('menu.is_active', 1)
        ->where('halaman.is_active',1)
        ->where('halaman.page_halaman', '>', 0)
        ->select('menu.*', 'halaman.*')
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



        return view('front.halaman', compact('halaman_detail', 'halaman', 'menu', 'grouphalaman', 'slug'));
    }

}
