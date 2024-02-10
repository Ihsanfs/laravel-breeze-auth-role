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
    try {
        // Validation rules
        $validationRules = [
            'nama_h' => 'required',
            'deskripsi_h' => 'required',
            'urutan' => 'required|integer',
            'is_active' => 'required|boolean',
            // 'g_halaman' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        // Validate input
        $this->validate($request, $validationRules);

        // Find menu
        $menu = Menu::find($request->nama_h);

        // Check if menu exists
        if (!$menu) {
            return back()->with(['error' => 'Menu not found']);
        }

        // Check if the page number already exists for the menu
        $pageExists = Halaman::where('menu_id', $menu->id)->where('page_halaman', $request->urutan)->exists();
        if ($pageExists) {
            return back()->with(['error' => 'Nomor halaman sudah ada']);
        }

        // Create a new Halaman object
        $halaman = new Halaman();
        $halaman->menu_id = $menu->id;
        $halaman->nama = $request->judul_halaman;
        $halaman->slug = Str::slug($request->judul_halaman);
        $halaman->deskripsi = $request->deskripsi_h;
        $halaman->view = 0;
        $halaman->page_halaman = $request->urutan;
        $halaman->is_active = $request->is_active;
        $halaman->user_id = Auth::id();
        $rand = rand(10, 999);

        // If a file is uploaded, save the image
        if ($request->hasFile('g_halaman')) {
            $file = $request->file('g_halaman');
            $fileName = $rand . '_' . $file->getClientOriginalName();
            $filePath = 'images/halaman/' . $fileName;
            $file->move(public_path('images/halaman'), $fileName);
            $halaman->gambar_h = $filePath;
        } else {
            $halaman->gambar_h = null;
        }

        // Save the page data to the database
        $halaman->save();

        // Determine user role and redirect to the appropriate route
        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';

        return redirect()->route($role . '.halaman')->with(['success' => 'Halaman berhasil ditambahkan']);
    } catch (\Exception $e) {
        // Handle errors by returning back to the previous page with an error message
        return back()->with(['error' => 'Error: ' . $e->getMessage()]);
    }
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
        $halaman->nama = $request->judul_halaman;
        $halaman->slug = Str::slug($request->judul_halaman);
        $halaman->deskripsi = $request->deskripsi_h;
        $halaman->page_halaman = $request->urutan;
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