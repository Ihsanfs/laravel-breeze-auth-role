<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
class FotoController extends Controller
{


    public function index(){

        $gallery = Gallery::all();
        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';
    return view('form.gallery.index', compact('gallery','role'));
    }

    public function create(){

   return view('form.gallery.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'judul' => 'required',
            'gambar_galery' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'required', // Assuming is_active is a required field
        ]);

        $gallery = new Gallery();
        $gallery->nama = $request->judul;

        if ($request->hasFile('gambar_galery')) {
            $file = $request->file('gambar_galery');
            $fileName = $file->getClientOriginalName();
            $filePath = 'images/gallery/' . $fileName;
            $file->move(public_path('images/gallery'), $fileName);
            $gallery->gambar_galery = $filePath;
        }

        $gallery->is_active = $request->is_active;
        $gallery->save();
        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';
        return redirect()->route($role.'.galery')->with(['success' => 'Gambar berhasil ditambahkan']);
    }




    public function edit($id){
        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';
        $gallery = Gallery::find($id);
        return view('form.gallery.edit', compact('gallery','role'));
    }

    public function destroy($id){
        $artikel = Gallery::find($id);
        $artikel->delete();
        return back()->with(['success' => 'gambar berhasil di hapus']);
    }

    public function update(Request $request,$id){

        // $this->validate($request, [
        //     'judul' => 'required',
        //     'gambar_galery' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',

        // ]);
        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';
        $artikel = Gallery::find($id);

        if (!$request->hasFile('gambar_galery')) {


            $artikel->nama = $request->judul;
            $artikel->is_active = $request->is_active;


            $artikel->update();
            return redirect()->route($role.'.galery')->with(['success' => 'Artikel berhasil diupdate']);
        } else {


            $file = $request->file('gambar_galery');
            $fileName = $file->getClientOriginalName();
            $filePath = 'images/artikel/' . $fileName;
            $file->move(public_path('images/artikel'), $fileName);
            $artikel->nama = $request->judul;
            $artikel->is_active = $request->is_active;
            $artikel->gambar_galery = $filePath;

            $artikel->update();

            return redirect()->route($role.'.galery')->with(['success' => 'Artikel berhasil diupdate']);
        }

    }
}
