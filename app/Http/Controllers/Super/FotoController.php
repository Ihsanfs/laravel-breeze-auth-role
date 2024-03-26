<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\album;
use App\Models\artikel;
use App\Models\Gallery;
use App\Models\halaman;
use App\Models\menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class FotoController extends Controller
{

    public function __construct()
    {
        $this->middleware('setUserRole');
    }


    public function index(Request $request)
    {

        $gallery = album::all();
        $foto = Gallery::join('album', 'album.id', '=', 'gallery.id_album')->where('gallery.is_active', 1)
            ->get();

        $role = $request->role;

        return view('form.gallery.index', compact('gallery', 'role', 'foto'));
    }

    public function create(Request $request)
    {

        $album = album::where('is_active', 1)->get();
        $role = $request->role;

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
        $role = $request->role;

        return redirect()->route($role . '.galery')->with(['success' => 'Gambar berhasil ditambahkan']);
    }




    public function edit(Request $request,$id)
    {
        $role = $request->role;

        $gallery = Gallery::find($id);

        // dd($gallery);;
        return view('form.gallery.editgaleri', compact('gallery', 'role'));
    }
    public function destroy($id)
    {
        $gallery = Gallery::find($id);

        if (!$gallery) {
            return back()->with(['error' => 'Galeri tidak ditemukan']);
        }
        if ($gallery->gambar) {
            $filePath = public_path($gallery->gambar);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }


        $gallery->delete();

        return back()->with(['success' => 'Gambar berhasil dihapus']);
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'judul' => 'required',
            'gambar_galery' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $role = $request->role;

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

        $role = $request->role;

        try {
            $this->validate($request, [
                'judul_album' => 'required|string|max:255',
                'gambar_album' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'is_active' => 'boolean',
            ]);

            $album = new Album();
            $album->nama_album = $request->judul_album;
            $album->user_id = Auth::user()->id;
            $album->slug = str::slug($request->judul_album);

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


            return redirect()->route($role . '.galery')->with(['success' => 'album berhasil dibuat']);
        } catch (\Exception $e) {

            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function album_isi($album)
    {

        //halaman urut
        $halaman = halaman::leftJoin('menu', 'halaman.menu_id', '=', 'menu.id')
            ->where('menu.is_active', 1)
            ->where('halaman.is_active', 1)
            ->where('halaman.page_halaman', '>', 0)
            ->select('menu.*', 'halaman.*')
            ->orderBy('halaman.page_halaman', 'ASC')
            ->get();

        $grouphalaman = $halaman->groupBy('menu_id');


        $menu = menu::where('is_active', 1)->get();
        $gambar = album::join('gallery', 'gallery.id_album', '=', 'album.id')
            ->where('slug', $album)
            ->select('gallery.id_album', 'gallery.gambar_galery', 'gallery.nama', 'gallery.id', 'gallery.is_active')
            ->groupBy('gallery.id_album', 'gallery.gambar_galery', 'gallery.nama', 'gallery.id', 'gallery.is_active')
            ->get();

        return view('front.albumdetail', compact('gambar','menu', 'grouphalaman','album'));
    }

    public function album_edit(Request $request,$id)
    {

        $album = album::findorfail($id);
        $role = $request->role;

        // dd($album);
        return view('form.gallery.edit', compact('album', 'role'));
    }

    public function album_update(Request $request, $id)
    {
        $this->validate($request, [
            'judul' => 'required',
            'gambar_album' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $role = $request->role;


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
        $artikel->slug = str::slug($request->judul);
        $artikel->is_active = $request->is_active;
        $artikel->user_id = Auth::user()->id;
        $artikel->update();

        return redirect()->route($role . '.galery')->with(['success' => 'album berhasil diupdate']);
    }


    public function album_delete($id)
    {
        $album = album::findOrFail($id);

        if (!empty($album->album_image)) {
            $file_path = public_path($album->album_image);
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        $album->delete();

        return back()->with(['success' => 'Album berhasil dihapus']);
    }

    public function album_galeri(Request $request,$id){
        $gambar = album::join('gallery', 'gallery.id_album', '=', 'album.id')
        ->where('album.id', $id)
        ->select('gallery.id_album', 'gallery.gambar_galery', 'gallery.nama', 'gallery.id', 'gallery.is_active')
        ->groupBy('gallery.id_album', 'gallery.gambar_galery', 'gallery.nama', 'gallery.id', 'gallery.is_active')
        ->get();
        // dd($gambar);
        $role = $request->role;

        return view('form.gallery.galeriall', compact('gambar','role'));
    }
}
