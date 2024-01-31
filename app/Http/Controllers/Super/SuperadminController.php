<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\kabid;
use App\Models\sekretaris;
use App\Models\tps;
use Illuminate\Http\Request;

class SuperadminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function sekretaris(){
        $sekretaris = sekretaris::all();
        return view('form.kategori.index', compact('sekretaris'));
    }

    public function kabid(){
        $kabid = kabid::all();
        return view('form.berita.index', compact('kabid'));
    }

    public function tps(){
        $tpssek = tps::join('sekretaris as s', 'tps.nama', '=', 's.nama')
        ->select('s.nama','s.tps','s.nama_gelar')
        ->get();

        $tps= tps::paginate(20);
        $semuatps = tps::all();
        return view('form.tps.index', compact('tps', 'tpssek','semuatps'));

    }

    public function tps_kabid(){
        $tpskabid = tps::join('kabid as s', 'tps.nama', '=', 's.nama')
        ->select('s.nama','s.tps','s.nama_gelar')
        ->get();

        $tps= tps::paginate(20);
        $semuatps = tps::all();
        return view('form.tps.kabid', compact('tps', 'tpskabid','semuatps'));

    }
}
