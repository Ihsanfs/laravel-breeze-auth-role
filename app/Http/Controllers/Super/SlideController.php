<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SlideController extends Controller
{
   public function index(){
    $slide = Slide::all();
    $userRole = Auth::user()->role_id;
    $role = ($userRole == 2) ? 'admin' : 'superadmin';
    return view ('form.slide.index', compact('slide','role'));
   }


   public function create(){
    $userRole = Auth::user()->role_id;
    $role = ($userRole == 2) ? 'admin' : 'superadmin';
    return view ('form.slide.create',compact('role'));

   }

   public function store(Request $request){

    try{
        $this->validate($request,[
            'judul_slide'=> 'required',
            'video_slide' => 'required|file|mimes:mp4,webm,ogg|max:20480' // max size in kilobytes


        ]);


            $slide = new Slide();
            $slide->judul_slide = $request->judul_slide;
            $slide->link = $request->link;
            $slide->is_active = $request->is_active;
            if ($request->hasFile('video_slide')) {
                $file = $request->file('video_slide');
                $fileName = $file->getClientOriginalName();
                $filePath = 'images/slide/' . $fileName;
                $file->move(public_path('images/slide'), $fileName);

                $slide->video_slide = $filePath;
            }
            $slide->save();
            $userRole = Auth::user()->role_id;
            $role = ($userRole == 2) ? 'admin' : 'superadmin';
        return redirect()->route($role.'.slider')->with(['success' =>'video berhasil di tambahkan']);
    }catch(\Exception $e){
        return back()->with(['error' =>'video gagal di tambahkan']);

    }


        }

   public function edit($id){
        $slide = Slide::find($id);
        $userRole = Auth::user()->role_id;
        $role = ($userRole == 2) ? 'admin' : 'superadmin';
        return view('form.slide.edit',compact('slide','role'));
   }

   public function update($id){

   }

   public function destroy($id){

    $slide = Slide::find($id);
    $slide->delete();
    return back()->with(['success'=>'Video Berhasil di Hapus']);
   }



}
