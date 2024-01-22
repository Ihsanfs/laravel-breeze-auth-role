<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\artikel;
use App\Models\kategori;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class SuperadminController extends Controller
{
    public function index()
    {
        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';
        return view('admin.index', compact('role'));
    }

    public function kategori()
    {

        $kategori = kategori::all();
        // dd($kategori);
        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';
        return view('form.kategori.index', compact('kategori','role'));
    }

    public function kategori_add()
    {
        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';
        return view('form.kategori.create', compact('role'));
    }

    public function berita()
{
    $userRole = Auth::user()->role_id;
    $role = ($userRole == 2) ? 'admin' : 'superadmin';
    $berita = Artikel::with('kategori')->get();
    return view('form.berita.index', compact('berita', 'role'));
}

public function berita_add()
{
    $userRole = Auth::user()->role_id;
    $role = ($userRole == 2) ? 'admin' : 'superadmin';
    $kategori_all = kategori::all();
    return view('form.berita.create', compact('kategori_all', 'role'));
}


public function slider()
{
    $userRole = Auth::user()->role_id;
    $role = ($userRole == 2) ? 'admin' : 'superadmin';
    return view('form.slide.index', compact('role'));
}

public function slider_add()
{
    $userRole = Auth::user()->role_id;
    $role = ($userRole == 2) ? 'admin' : 'superadmin';
    return view('form.slide.create', compact('role'));
}


    public function kategori_store(Request $request)
    {

        $this->validate($request, [
            'nama_kategori' => 'required'
        ]);


        kategori::create([
            'nama_kategori' => $request->nama_kategori,
            'slug' => Str::slug($request->nama_kategori)
        ]);

        return redirect()->back()->with(['success' => 'data berhasil ditambahkan']);
    }


    public function kategori_show(Request $request, $id)
    {


        $kategori = kategori::find($id);
        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';
        return view('form.kategori.edit', compact('kategori','role'));
    }

    public function kategori_update(Request $request, $id)
    {

        $kategori_all = kategori::findOrFail($id);
        $kategori_all['slug'] = Str::slug($request->nama_kategori);
        $kategori_all->nama_kategori = $request->nama_kategori;
        $kategori_all->save();
        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';
        return redirect()->route($role . '.kategori')->with(['success' => 'Data berhasil di edit']);
    }

    public function kategori_hapus($id)
    {

        $kategori = kategori::find($id);
        $kategori->delete();
        return redirect()->back()->with(['success' => 'data berhasil di hapus']);
    }

    public function berita_store(Request $request)
    {
        $this->validate($request, [
            'judul' => 'required',
            'gambar_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',

        ]);


        $berita = new artikel;
        $berita->judul = $request->judul;
        $berita->slug = Str::slug($request->judul);
        $berita->user_id = Auth::id();
        $berita->body = $request->body;
        if ($request->hasFile('gambar_file')) {
            $rand = rand(10, 999);
            $file = $request->file('gambar_file');
            $fileName = $file->getClientOriginalName();
            $filePath = 'images/artikel/' . $rand . $fileName; // Menggunakan $rand di sini
            $file->move(public_path('images/artikel'), $rand . $fileName); // Menggunakan $rand di sini

            $berita->gambar_artikel = $filePath;
        }

        $berita->kategori_id = $request->kategori_id;
        $berita->is_active = $request->is_active;


        $berita->save();
        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';
        return redirect()->route($role. '.berita')->with(['success' => 'artikel berhasil di tambahkan']);
    }


    public function berita_edit($id)
    {
        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';
        $berita = artikel::find($id);
        $kategori_all = kategori::all();
        return view('form.berita.edit', compact('berita', 'kategori_all','role'));
    }

    public function berita_update(Request $request, $id)
    {
        $artikel = artikel::find($id);
        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';
        if (!$request->hasFile('gambar_file')) {

            $artikel->judul = $request->judul;
            $artikel->slug = Str::slug($request->judul);
            $artikel->user_id = Auth::id();
            $artikel->kategori_id = $request->kategori_id;
            $artikel->body = $request->body;
            $artikel->is_active = $request->is_active;
            $artikel->update();

            return redirect()->route($role.'.berita')->with(['success' => 'Artikel berhasil diupdate']);
        } else {
            // File uploaded, update file and other fields
            $file = $request->file('gambar_file');
            $fileName = $file->getClientOriginalName();
            $filePath = 'images/artikel/' . $fileName;
            $file->move(public_path('images/artikel'), $fileName);


            $artikel->judul = $request->judul;
            $artikel->slug = Str::slug($request->judul);
            $artikel->user_id = Auth::id();
            $artikel->kategori_id = $request->kategori_id;
            $artikel->body = $request->body;
            $artikel->is_active = $request->is_active;
            $artikel->gambar_artikel = $filePath;

            $artikel->update();
            $userRole = Auth::user()->role_id;
            $role = ($userRole == 2) ? 'admin' : 'superadmin';
            return redirect()->route( $role.'.berita')->with(['success' => 'Artikel berhasil diupdate']);
        }
    }



    public function berita_delete($id){
        $artikel = Artikel::find($id);
        $artikel->gambar_artikel;
        $artikel->delete();
        return back()->with(['success' => 'Artikel berhasil di hapus']);

    }
}
