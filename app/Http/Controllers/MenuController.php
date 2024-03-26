<?php

namespace App\Http\Controllers;

use App\Models\menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MenuController extends Controller
{

    public function __construct()
    {
        $this->middleware('setUserRole');
    }

    public function index(Request $request){

        $menu = menu::all();
        $role = $request->role;

        return view('form.menu.index',compact('menu','role'));
    }


    public function create(Request $request){
        $role = $request->role;

        return view('form.menu.create',compact('role'));

    }

    public function edit(Request $request,$id){
        $role = $request->role;

    $menu = menu::find($id);
    return view('form.menu.edit',compact('menu','role'));

    }

    public function update(Request $request, $id)
{
    $menu = Menu::find($id);
    $menu->nama = $request->nama_menu;
    if($menu->status == 4){
        $menu->slug = str::slug($request->nama_menu);

        }
    $menu->is_active = $request->is_active;
    $menu->deskripsi_page = $request->deskripsi_page;

    // Check if a new image is uploaded
    if ($request->hasFile('gambar_page')) {
        $rand = rand(10, 999);
        $file = $request->file('gambar_page');
        $fileName = $file->getClientOriginalName();
        $filePath = 'images/gambar_page/' . $rand . $fileName;
        $file->move(public_path('images/gambar_page'), $rand . $fileName);
        $menu->gambar_page = $filePath;
    }
    else {
        $menu->gambar_page = $menu->gambar_page;
    }

    $menu->user_id = Auth::user()->id;
    $menu->update();

    $role = $request->role;


    return redirect()->route($role . '.menu')->with(['success' => 'Menu berhasil diperbaharui']);
}


    public function store(Request $request){

        $menu = new menu();
        $menu->nama = $request->nama_menu;
        if($request->menu_pilih == 4){
        $menu->slug = str::slug($request->nama_menu);

        }

        $menu->user_id = Auth::user()->id;
        $menu->url = $request->url_menu;
        $menu->is_active = $request->is_active;
        $menu->status = $request->menu_pilih;
        $menu->deskripsi_page = $request->deskripsi_page;
        if ($request->hasFile('gambar_page')) {
            $rand = rand(10, 999);
            $file = $request->file('gambar_page');
            $fileName = $file->getClientOriginalName();
            $filePath = 'images/gambar_page/' . $rand . $fileName;
            $file->move(public_path('images/gambar_page'), $rand . $fileName);
            $menu->gambar_page = $filePath;
        }
        $menu->save();
        $role = $request->role;

        return redirect()->route($role . '.menu')->with(['success' => 'Menu berhasil ditambahkan']);
    }

    public function delete($id){
        $menu = menu::find($id);
        $menu->delete();
        return back()->with(['success'=>'menu berhasil di hapus']);
    }

}
