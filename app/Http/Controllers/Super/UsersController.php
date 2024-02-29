<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index()
    {

        $user = User::find(auth()->user()->id);
        // dd($user);
        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';
        return view('form.profil.index', compact('user', 'role'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $rand = rand(10, 999);
        if ($request->hasFile('gambar_user')) {
            $file = $request->file('gambar_user');
            $fileName = $rand . '_' . $file->getClientOriginalName();
            $filePath = 'images/profil/' . $fileName;
            $file->move(public_path('images/profil'), $fileName);
            $user->gambar = $filePath;
        }
        $user->name = $request->nama;
        $user->update();
        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';
        return redirect()->route($role . '.users')->with(['succes' => 'data berhasil di update']);
    }

    public function create(){

        $roles = Role::all();
        $userRole = Auth::user()->role_id;
        $role = ($userRole == 1) ? 'superadmin' : '';
        return view('form.profil.create',compact('role','roles'));
    }
    public function store(Request $request){

        try {
            $this->validate($request, [

                'is_active' => 'required',
                'role' => 'required',
                'password' => 'required',

            ]);

            if($request->gambar_user){
                $this->validate($request, [
                    'gambar_user' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                ]);
            }

            $roles = Role::find($request->role);

            if (!$roles) {
                return back()->with(['error' => 'Role not found']);
            }

            $users = new User();
            $rand = rand(10, 999);
            $users->name = $request->nama;
            $users->role_id = $roles->id;
            $users->password = Hash::make($request->password);
            $users->email = $request->email;
            $users->is_active = $request->is_active;

            if ($request->hasFile('gambar_user')) {
                $file = $request->file('gambar_user');
                $fileName = $rand . '_' . $file->getClientOriginalName();
                $filePath = 'images/profil/' . $fileName;
                $file->move(public_path('images/profil'), $fileName);
                $users->gambar = $filePath;
            }
            // dd($users);
            $users->save();

            return redirect()->route('superadmin.users_all')->with(['success' => 'Data berhasil ditambahkan']);
        } catch (\Exception $e) {
            return back()->with(['error' => 'Data gagal ditambahkan' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $roles = Role::all();

        $user = User::find($id);
        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';
        return view('form.profil.edit', compact('user', 'role','roles'));
    }

    public function password()
    {

        $user = User::find(auth()->user()->id);
        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';
        return view('form.profil.password', compact('user','role'));
    }

    public function password_update(Request $request, $id)
    {

        $user = User::find($id);
        $user->password = Hash::make($request->password);
        $user->update();
        return back()->with(['success' => 'password berhasil di rubah']);
    }

    public function tampil_user(){

        $user = User::paginate(5);
        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';
        return view('form.profil.tampil_user',compact('user','role'));
    }

    public function status(Request $request, $id)
{
    $user = User::find($id);

    if (!$user) {
        return response()->json(['error' => 'User not found.'], 404);
    }

    if ($user->is_active == 1) {
        $user->is_active = 0;

    $user->save();
        return back()->with(['success'=>'user berhasil di matikan']);
    } elseif ($user->is_active == 0) {
        $user->is_active = 1;

    $user->save();
        return back()->with(['success'=>'user berhasil di aktifkan']);

    }

}

public function hapus_user($id){

    $user = User::find($id);
    $user->delete();
    return back()->with(['success'=>'user berhasil di hapus']);
}

public function edit_user($id){

    $user = User::find($id);
    $roles = Role::all();
    $userRole = Auth::user()->role_id;
    $role = ($userRole == 1) ? 'superadmin' : '';
    return view('form.profil.user_edit',compact('user','roles','role'));

}

public function update_user(Request $request, $id){
    try {
    $user = User::find($id);
    $user->name = $request->nama;
    $user->is_active = $request->is_active;
    $user->role_id = $request->role;
    if($request->password){
        $user->password = Hash::make($request->password);

    }

    if ($request->hasFile('gambar_user')) {
        $file = $request->file('gambar_user');
        $fileName = $file->getClientOriginalName();
        $filePath = 'images/profil/' . $fileName;
        $file->move(public_path('images/profil/'), $fileName);
        $user->gambar = $filePath;
    }

    $user->update();

    return redirect()->route('superadmin.users_all')->with(['success' => 'Data berhasil update']);
            } catch (\Exception $e) {
                return back()->with(['error' => 'Data gagal di update']);
            }
}

}
