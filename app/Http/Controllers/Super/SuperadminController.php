<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\artikel;
use App\Models\artikeltag;
use App\Models\Gallery;
use App\Models\halaman;
use App\Models\kategori;
use App\Models\kategori_tag;
use App\Models\Slide;
use App\Models\tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class SuperadminController extends Controller
{

    public function __construct()
    {
        $this->middleware('setUserRole');
    }


    public function index(Request $request)
    {
        $berita = artikel::count();
        $halaman = halaman::count();
        $video = Slide::count();
        $galery = Gallery::count();

        $role = $request->role;

        return view('admin.index', compact('role', 'berita', 'halaman', 'video', 'galery'));
    }

    public function kategori(Request $request)
    {

        $kategori = kategori::all();

        $role = $request->role;

        return view('form.kategori.index', compact('kategori', 'role'));
    }

    public function berita_search(Request $request)
    {
        $search = $request->input('search');
        $berita = Artikel::where('slug', 'like', '%' . $search . '%')->get();
        return response()->json($berita);
    }

    public function kategori_add(Request $request)
    {
        $role = $request->role;

        return view('form.kategori.create', compact('role'));
    }

    public function berita(Request $request)
    {
        $role = $request->role;

        $berita = Artikel::paginate(10);
        return view('form.berita.index', compact('berita', 'role'));
    }

    public function berita_detail(Request $request,$slug)
    {

        $berita = Artikel::where('slug', $slug)->paginate();

        $role = $request->role;


        return view('form.berita.result', compact('berita', 'role'));
    }

    public function berita_add(Request $request)
    {
        $role = $request->role;

        $kategori_all = kategori::all();
        $tag = tag::all();
        return view('form.berita.create', compact('kategori_all', 'role', 'tag'));
    }


    public function slider(Request $request)
    {
        $role = $request->role;

        return view('form.slide.index', compact('role'));
    }

    public function slider_add(Request $request)
    {
        $role = $request->role;

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

        return redirect()->route($role . '.kategori')->with(['success' => 'Kategori berhasil di tambahkan']);
    }


    public function kategori_show(Request $request, $id)
    {


        $kategori = kategori::find($id);
        $role = $request->role;

        return view('form.kategori.edit', compact('kategori', 'role'));
    }

    public function kategori_update(Request $request, $id)
    {

        $kategori_all = kategori::findOrFail($id);
        $kategori_all['slug'] = Str::slug($request->nama_kategori);
        $kategori_all->nama_kategori = $request->nama_kategori;
        $kategori_all->save();
        $role = $request->role;

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

            $berita->is_active = $request->is_active;
            $berita->save();

            if ($berita) {
                if ($request->has('kategori_id')) {
                foreach ($request->kategori_id as $tagId) {
                    $artikel_id = new kategori_tag();
                    $artikel_id->artikel_id = $berita->id;
                    $artikel_id->kategori_id = $tagId;
                    $artikel_id->save();
                }
            }
            }

            if ($berita) {
                if ($request->has('tag_id')) {
                    foreach ($request->tag_id as $tagId) {
                        $tag_artikel = new artikeltag();
                        $tag_artikel->artikel_id = $berita->id;
                        $tag_artikel->tag_id = $tagId;
                        $tag_artikel->save();
                    }
                }
            }

            $role = $request->role;


            return redirect()->route($role . '.berita')->with(['success' => 'Artikel berhasil ditambahkan']);
        } catch (\Exception $e) {
            return back()->with(['error' => 'Error: ' . $e->getMessage()]);
        }
    }



    public function berita_edit(Request $request,$id)
    {
        $role = $request->role;

        $berita = artikel::find($id);
        $tag = artikeltag::leftjoin('artikels as a', 'a.id', '=', 'artikels_tag.artikel_id')
            ->leftjoin('tag', 'tag.id', '=', 'artikels_tag.tag_id')->where('artikels_tag.artikel_id', $id)
            ->get();
            $kategori_tag = kategori_tag::leftjoin('artikels as b', 'b.id', '=', 'kategori_tag.artikel_id')
            ->leftjoin('kategori', 'kategori.id', '=', 'kategori_tag.kategori_id')
            ->where('kategori_tag.artikel_id', $id)
            ->get();
            // dd($kategori_tag);
            $kategori_artikel = $kategori_tag->pluck('id')->toArray();

            // dd($kategori_tag);
        $selectedTags = $tag->pluck('id')->toArray();

        $kategori_all = kategori::all();
        $tag_all = tag::all();
        return view('form.berita.edit', compact('berita','kategori_tag', 'tag_all', 'kategori_all', 'role', 'tag', 'selectedTags','kategori_artikel'));
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
            $kategori_multi = kategori_tag::get();
            if (!$artikel) {
                return back()->with(['error' => 'Artikel not found']);
            }

            $role = $request->role;


            if (!$request->hasFile('gambar_file')) {
                // No new file uploaded, update other fields
                $artikel->judul = $request->judul;
                $artikel->slug = str_replace(' ', '-', Str::slug($request->judul));
                $artikel->user_id = Auth::id();
                // $artikel->kategori_id = $request->kategori_id;
                $artikel->body = $request->body;
                $artikel->is_active = $request->is_active;
                $artikel->update();

                if($artikel){
                    kategori_tag::where('artikel_id', $artikel->id)->delete();
                    foreach ($request->kategori_id as $tagId) {
                        $tag_artikel = new kategori_tag();
                        $tag_artikel->artikel_id = $artikel->id;
                        $tag_artikel->kategori_id = $tagId;
                        $tag_artikel->save();
                    }
                }



                if ($request->has('tag_id')) {

                    artikeltag::where('artikel_id', $artikel->id)->delete();
                        foreach ($request->tag_id as $tagId) {
                            $tag_artikel = new artikeltag();
                            $tag_artikel->artikel_id = $artikel->id;
                            $tag_artikel->tag_id = $tagId;
                            $tag_artikel->save();
                        }
                    }

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
                // $artikel->kategori_id = $request->kategori_id;
                $artikel->body = $request->body;
                $artikel->is_active = $request->is_active;
                $artikel->gambar_artikel = $filePath;
                $artikel->update();

                if($artikel){
                    kategori_tag::where('artikel_id', $artikel->id)->delete();
                    foreach ($request->kategori_id as $tagId) {
                        $tag_artikel = new kategori_tag();
                        $tag_artikel->artikel_id = $artikel->id;
                        $tag_artikel->kategori_id = $tagId;
                        $tag_artikel->save();
                    }
                }

                if ($request->has('tag_id')) {

                    artikeltag::where('artikel_id', $artikel->id)->delete();
                        foreach ($request->tag_id as $tagId) {
                            $tag_artikel = new artikeltag();
                            $tag_artikel->artikel_id = $artikel->id;
                            $tag_artikel->tag_id = $tagId;
                            $tag_artikel->save();
                        }
                    }
                return redirect()->route($role . '.berita')->with(['success' => 'Artikel berhasil diupdate']);
            }
        } catch (\Exception $e) {
            return back()->with(['error' => 'Error: ' . $e->getMessage()]);
        }
    }



    public function berita_delete($id)
    {
        $artikel = Artikel::find($id);
        $artikel->gambar_artikel;

        if (!empty($artikel->gambar_artikel)) {
            $file_path = public_path($artikel->gambar_artikel);
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
        $artikel->delete();
        return back()->with(['success' => 'Artikel berhasil di hapus']);
    }
}
