<?php

namespace App\Http\Controllers;

use App\Models\menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function index(){

        $menu = menu::all();
        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';
        return view('form.menu.index',compact('menu','role'));
    }


    public function create(){
        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';
        return view('form.menu.create',compact('role'));

    }

    public function edit($id){
        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';
    $menu = menu::find($id);
    return view('form.menu.edit',compact('menu','role'));

    }

    public function update(Request $request,$id){
        $menu = menu::find($id);
        $menu->nama = $request->nama_menu;
        $menu->is_active = $request->is_active;
        $menu->user_id = Auth::user()->id;
        $menu->update();
        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';

        return redirect()->route($role.'.menu')->with(['success'=>'menu berhasil di perbaharui']);
    }

    public function store(Request $request){
        $menu = new menu();
        $menu->nama = $request->nama_menu;
        $menu->user_id = Auth::user()->id;
        $menu->is_active = $request->is_active;
        $menu->save();
        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';
        return redirect()->route($role . '.menu')->with(['success' => 'Menu berhasil ditambahkan']);
    }

    public function delete($id){
        $menu = menu::find($id);
        $menu->delete();
        return back()->with(['success'=>'menu berhasil di hapus']);
    }

}
