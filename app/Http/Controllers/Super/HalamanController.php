<?php

namespace App\Http\Controllers\super;

use App\Http\Controllers\Controller;
use App\Models\halaman;
use App\Models\menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Illuminate\Validation\ValidationException;
class HalamanController extends Controller
{

    public function index(){

        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';
        $halaman = halaman::with('author_halaman')->get();
        return view('form.halaman.index',compact('halaman','role'));
    }

    public function create(){
        $menu = menu::all();
        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';
        return view('form.halaman.create',compact('role','menu'));

    }

    public function store(Request $request)
    {

            $menu = menu::find($request->nama_h);


            $halaman = new Halaman();
            $halaman->menu_id = $menu->id;
            $halaman->nama = $menu->nama;
            $halaman->slug = Str::slug($menu->nama);
            $halaman->deskripsi = $request->deskripsi_h;
            $halaman->view = 0;
            $halaman->is_active = $request->is_active;
            $halaman->user_id = Auth::id();
            $rand = rand(10, 999);

            if ($request->hasFile('g_halaman')) {
                $file = $request->file('g_halaman');
                $fileName = $rand . '_' . $file->getClientOriginalName();
                $filePath = 'images/halaman/' . $fileName;
                $file->move(public_path('images/halaman'), $fileName);
                $halaman->gambar_h = $filePath;
            }

            $halaman->save();

            $userRole = Auth::user()->role_id;
            $role = ($userRole == 2) ? 'admin' : 'superadmin';

            return redirect()->route($role . '.halaman')->with(['success' => 'Halaman berhasil ditambahkan']);

    }

    public function edit($id){
        $halaman = halaman::find($id);
        $menu = menu::all();
        $userRole = Auth::user()->role_id;
            $role = ($userRole == 2) ? 'admin' : 'superadmin';

            // dd($halaman);
            return view('form.halaman.edit', compact('halaman','role','menu'));
    }

    public function update(Request $request, $id){

        $halaman = halaman::find($id);
        $menu =   menu::find($request->nama_h);

        $halaman->menu_id = $menu->id;
        $halaman->nama = $menu->nama;
        $halaman->slug = Str::slug($menu->nama);
        $halaman->deskripsi = $request->deskripsi_h;
        $halaman->user_id = Auth::user()->id;
        $halaman->is_active = $request->is_active;
        if (!$request->hasFile('g_halaman')) {
            $halaman->update();
            $userRole = Auth::user()->role_id;
            $role = ($userRole == 2) ? 'admin' : 'superadmin';
            return redirect()->route($role.'.halaman')->with(['success' => 'Halaman berhasil diupdate']);
        } else {

            $rand = rand(10, 999);
            $file = $request->file('g_halaman');
            $fileName = $rand . '_' . $file->getClientOriginalName();
            $filePath = 'images/halaman/' . $fileName;
            $file->move(public_path('images/halaman'), $fileName);

            $halaman->gambar_h = $filePath;
            $halaman->update();

            $userRole = Auth::user()->role_id;
            $role = ($userRole == 2) ? 'admin' : 'superadmin';
            return redirect()->route($role.'.halaman')->with(['success' => 'Halaman berhasil diupdate']);
        }
    }


    public function destroy($id){

        $halaman = halaman::find($id);
        $halaman->delete();
        return redirect()->back()->with(['success' => 'Halaman berhasil dihapus']);

    }

}
