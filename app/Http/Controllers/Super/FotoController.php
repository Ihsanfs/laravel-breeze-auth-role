<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\album;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class FotoController extends Controller
{


    public function index()
    {

        $gallery = album::all();
        $foto = Gallery::join('album', 'album.id', '=', 'gallery.id_album')->where('gallery.is_active', 1)
        ->get();

        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';
        return view('form.gallery.index', compact('gallery', 'role', 'foto'));
    }

    public function create()
    {

        $album = album::where('is_active', 1)->get();
        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';
        return view('form.gallery.create', compact('role', 'album'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'judul' => 'required',
            'album' => 'required',
            'gambar_galery' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'required',
        ]);

        $gallery = new Gallery();
        $gallery->nama = $request->judul;
        $gallery->id_album = $request->album;
        if ($request->hasFile('gambar_galery')) {
            $rand = rand(10, 999);
            $file = $request->file('gambar_galery');
            $fileName = $file->getClientOriginalName();
            $filePath = 'images/gallery/' . $rand . $fileName;
            $file->move(public_path('images/gallery'), $rand . $fileName);
            $gallery->gambar_galery = $filePath;
        }

        $gallery->is_active = $request->is_active;
        $gallery->save();
        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';
        return redirect()->route($role . '.galery')->with(['success' => 'Gambar berhasil ditambahkan']);
    }




    public function edit($id)
    {
        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';
        $gallery = Gallery::find($id);

        // dd($gallery);;
        return view('form.gallery.editgaleri', compact('gallery', 'role'));
    }

    public function destroy($id)
    {
        $artikel = Gallery::find($id);
        $artikel->delete();
        return back()->with(['success' => 'gambar berhasil di hapus']);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'judul' => 'required',
            'gambar_galery' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';
        $gallery = Gallery::find($id);

        $gallery->nama = $request->judul;
        $gallery->is_active = $request->is_active;

        if ($request->hasFile('gambar_galery')) {
            $file = $request->file('gambar_galery');
            $rand = rand(10, 999);
            $fileName = $file->getClientOriginalName();
            $filePath = 'images/artikel/' . $rand . $fileName;
            $file->move(public_path('images/artikel'), $rand . $fileName);
            $gallery->gambar_galery = $filePath;
        }

        $gallery->update();

        return redirect()->route($role . '.galery')->with(['success' => 'gallery berhasil diupdate']);
    }


    public function album()
    {

        $album =  new album();
    }

    public function album_create()
    {

        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';
        return view('form.gallery.album', compact('role'));
    }

    public function album_store(Request $request)
    {

        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';
        try {
            $this->validate($request, [
                'judul_album' => 'required|string|max:255',
                'gambar_album' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'is_active' => 'boolean',
            ]);

            $album = new Album();
            $album->nama_album = $request->judul_album;
            $album->user_id = Auth::user()->id;

            if ($request->hasFile('gambar_album')) {
                $rand = rand(10, 999);
                $file = $request->file('gambar_album');
                $fileName = $file->getClientOriginalName();
                $filePath = 'images/album/' . $rand . $fileName;
                $file->move(public_path('images/album'), $rand . $fileName);
                $album->album_image  = $filePath;
            }

            $album->is_active = $request->is_active;
            $album->save();

            // Redirect somewhere after successful save
            return redirect()->route($role . '.galery')->with(['success' => 'album berhasil dibuat']);
        } catch (\Exception $e) {

            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function album_isi($id)
    {


        $gambar = album::join('gallery', 'album.id', '=', 'gallery.id_album')
            ->where('id_album', $id)
            ->select('gallery.id_album', 'gallery.gambar_galery', 'gallery.nama', 'gallery.id','gallery.is_active')
            ->groupBy('gallery.id_album', 'gallery.gambar_galery', 'gallery.nama', 'gallery.id','gallery.is_active')
            ->get();

        return response()->json($gambar);


    }

    public function album_edit($id)
    {

        $album = album::findorfail($id);
        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';
        // dd($album);
        return view('form.gallery.edit', compact('album', 'role'));
    }

    public function album_update(Request $request, $id)
    {
        $this->validate($request, [
            'judul' => 'required',
            'gambar_album' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';

        $artikel = album::find($id);

        if ($request->hasFile('gambar_album')) {
            $file = $request->file('gambar_album');
            $rand = rand(10, 999);
            $fileName = $file->getClientOriginalName();
            $filePath = 'images/album/' . $rand . $fileName;
            $file->move(public_path('images/album'), $rand . $fileName);
            $artikel->album_image = $filePath;
        }

        $artikel->nama_album = $request->judul;
        $artikel->is_active = $request->is_active;
        $artikel->user_id = Auth::user()->id;
        $artikel->update();

        return redirect()->route($role . '.galery')->with(['success' => 'album berhasil diupdate']);
    }


    public function album_delete($id)
    {
        $album = album::findOrFail($id);

        // Hapus file gambar terkait album jika ada
        if (!empty($album->album_image)) {
            $file_path = public_path($album->album_image);
            if (file_exists($file_path)) {
                unlink($file_path); // Hapus file gambar
            }
        }

        $album->delete();

        return back()->with(['success' => 'Album berhasil dihapus']);
    }
}
