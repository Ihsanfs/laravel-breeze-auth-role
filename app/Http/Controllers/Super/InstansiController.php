<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\instansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class InstansiController extends Controller
{
    public function index(){

        $instansi = instansi::first();
        // dd($instansi);
        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';
        return view('form.instansi.index', compact('instansi','role'));
    }

    public function edit($id){
        $instansi = instansi::find($id);
        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';
        return view('form.instansi.edit', compact('instansi','role'));
    }

    public function create(){

        return view('form.instansi.create');
    }
    public function update(Request $request, $id)
    {

        $instansi = Instansi::findOrFail($id);
        $instansi->nama = $request->nama;
        $instansi->nagari = $request->nagari;
        $instansi->kecamatan = $request->kecamatan;
        $instansi->kabupaten = $request->kabupaten;
        $instansi->link = $request->sosmed;

        // Mengatur nama file unik dengan menggabungkan rand() pada nama file
        $rand = rand(10, 999);

        // Memproses gambar_instansi
        if ($request->hasFile('gambar_instansi')) {
            $file = $request->file('gambar_instansi');
            $fileName = $rand . '_' . $file->getClientOriginalName();
            $filePath = 'images/profil/' . $fileName;
            $file->move(public_path('images/profil'), $fileName);
            $instansi->foto_instansi = $filePath;
        }


        if ($request->hasFile('gambar_kepala')) {
            $file = $request->file('gambar_kepala');
            $fileName = $rand . '_' . $file->getClientOriginalName();
            $filePath = 'images/profil/' . $fileName;
            $file->move(public_path('images/profil'), $fileName);
            $instansi->foto_kepala = $filePath;
        }



        // dd($instansi);
        $instansi->update();
        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';
        return redirect()->route($role. '.instansi')->with('success', 'Data berhasil diperbarui');
    }


    public function destroy(){

    }

    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'nagari' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kabupaten' => 'required|string|max:255',
            'gambar_instansi' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'gambar_kepala' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';
        // Jika validasi gagal
        if ($validator->fails()) {
            return redirect()
                ->route($role. '.instansi')
                ->withErrors($validator)
                ->withInput();
        }

        // Jika validasi berhasil, lanjutkan penyimpanan data
        $instansi = new Instansi();

        // Pengaturan atribut
        $instansi->nama = $request->nama;
        $instansi->nagari = $request->nagari;
        $instansi->kecamatan = $request->kecamatan;
        $instansi->kabupaten = $request->kabupaten;
        $instansi->link = $request->sosmed;

        // Mengatur nama file unik dengan menggabungkan rand() pada nama file
        $rand = rand(10, 999);

        // Memproses gambar_instansi
        if ($request->hasFile('gambar_instansi')) {
            $file = $request->file('gambar_instansi');
            $fileName = $rand . '_' . $file->getClientOriginalName();
            $filePath = 'images/profil/' . $fileName;
            $file->move(public_path('images/profil'), $fileName);
            $instansi->foto_instansi = $filePath;
        }

        // Memproses gambar_kepala
        if ($request->hasFile('gambar_kepala')) {
            $file = $request->file('gambar_kepala');
            $fileName = $rand . '_' . $file->getClientOriginalName();
            $filePath = 'images/profil/' . $fileName;
            $file->move(public_path('images/profil'), $fileName);
            $instansi->foto_kepala = $filePath;
        }


        $instansi->save();
        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';
        return redirect()->route($role. '.instansi')->with('success', 'Data berhasil ditambahkan');
    }
}
