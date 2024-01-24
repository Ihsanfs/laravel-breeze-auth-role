<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\artikel;
use App\Models\Gallery;
use App\Models\halaman;
use App\Models\kategori;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class SuperadminController extends Controller
{
    public function index()
    {
        $berita = artikel::count();
        $userRole = Auth::user()->role_id;
        $halaman = halaman::count();
        $video = Slide::count();
        $galery = Gallery::count();

        $role = ($userRole == 2) ? 'admin' : 'superadmin';
        return view('admin.index', compact('role','berita','halaman','video','galery'));
    }

    public function kategori()
    {

        $kategori = kategori::all();
        // dd($kategori);
        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';
        return view('form.kategori.index', compact('kategori','role'));
    }

    public function berita_search(Request $request){
        $search = $request->input('search');
        $berita = Artikel::where('slug', 'like', '%' . $search . '%')->get();
        return response()->json($berita);

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
    $berita = Artikel::with('kategori')->paginate(10);
    return view('form.berita.index', compact('berita', 'role'));
}

        public function berita_detail($slug){

            $berita = Artikel::where('slug', $slug)->paginate();

            $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';

        return view('form.berita.result', compact('berita', 'role'));


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

        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';

        kategori::create([
            'nama_kategori' => $request->nama_kategori,
            'slug' => Str::slug($request->nama_kategori)
        ]);

        return redirect()->route($role.'.kategori')->with(['success'=>'Kategori berhasil di tambahkan']);
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
        try {
            $this->validate($request, [
                'judul' => 'required',
                'gambar_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'body' => 'required',
                'is_active' => 'required',
            ]);

            $berita = new Artikel();
            $berita->judul = $request->judul;
            $berita->slug = str_replace(' ', '-', Str::slug($request->judul));
            $berita->user_id = Auth::id();
            $berita->body = $request->body;

            if ($request->hasFile('gambar_file')) {
                $rand = rand(10, 999);
                $file = $request->file('gambar_file');
                $fileName = $file->getClientOriginalName();
                $filePath = 'images/artikel/' . $rand . $fileName;
                $file->move(public_path('images/artikel'), $rand . $fileName);
                $berita->gambar_artikel = $filePath;
            }

            $berita->kategori_id = $request->kategori_id;
            $berita->is_active = $request->is_active;

            $berita->save();

            $userRole = Auth::user()->role_id;
            $role = ($userRole == 2) ? 'admin' : 'superadmin';

            return redirect()->route($role . '.berita')->with(['success' => 'Artikel berhasil ditambahkan']);
        } catch (\Exception $e) {
            return back()->with(['error' => 'Error: ' . $e->getMessage()]);
        }
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


        try {
            $this->validate($request, [
                'judul' => 'required',
                'body' => 'required',
                'is_active' => 'required',
            ]);

            $artikel = Artikel::find($id);

            if (!$artikel) {
                return back()->with(['error' => 'Artikel not found']);
            }

            $userRole = Auth::user()->role_id;
            $role = ($userRole == 2) ? 'admin' : 'superadmin';

            if (!$request->hasFile('gambar_file')) {
                // No new file uploaded, update other fields
                $artikel->judul = $request->judul;
                $artikel->slug = str_replace(' ', '-', Str::slug($request->judul));
                $artikel->user_id = Auth::id();
                $artikel->kategori_id = $request->kategori_id;
                $artikel->body = $request->body;
                $artikel->is_active = $request->is_active;
                $artikel->update();

                return redirect()->route($role . '.berita')->with(['success' => 'Artikel berhasil diupdate']);
            } else {
                // File uploaded, update file and other fields
                $file = $request->file('gambar_file');
                $fileName = $file->getClientOriginalName();
                $filePath = 'images/artikel/' . $fileName;
                $file->move(public_path('images/artikel'), $fileName);

                $artikel->judul = $request->judul;
                $artikel->slug = str_replace(' ', '-', Str::slug($request->judul));
                $artikel->user_id = Auth::id();
                $artikel->kategori_id = $request->kategori_id;
                $artikel->body = $request->body;
                $artikel->is_active = $request->is_active;
                $artikel->gambar_artikel = $filePath;
                $artikel->update();

                return redirect()->route($role . '.berita')->with(['success' => 'Artikel berhasil diupdate']);
            }
        } catch (\Exception $e) {
            return back()->with(['error' => 'Error: ' . $e->getMessage()]);
        }
    }



    public function berita_delete($id){
        $artikel = Artikel::find($id);
        $artikel->gambar_artikel;
        $artikel->delete();
        return back()->with(['success' => 'Artikel berhasil di hapus']);

    }
}
