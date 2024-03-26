<?php

namespace App\Http\Controllers;

use App\Models\slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Backtrace\File;

class SliderController extends Controller
{
    public function __construct()
    {
        $this->middleware('setUserRole');
    }


    public function index(Request $request)
    {

        $slider = slider::all();
        $role = $request->role;

        return view('form.slider.index', compact('slider', 'role'));
    }

    public function create(Request $request)
    {
        $role = $request->role;
        return view('form.slider.create', compact('role'));
    }

    public function store(Request $request)
    {
        $slider = new Slider();
        $slider->judul_slider = $request->judul_slider;

        if ($request->hasFile('gambar_slider')) {
            $file = $request->file('gambar_slider');
            $rand = rand(10, 999);
            $fileName = $file->getClientOriginalName();
            $filePath = 'images/slider/' . $rand . $fileName;
            $file->move(public_path('images/slider'), $rand . $fileName);
            $slider->gambar_slider = $filePath;
        }

        $slider->is_active = $request->is_active;
        $slider->save();

        $role = $request->role;

        return redirect()->route($role.'.slider_index')->with('success', 'Slider berhasil ditambahkan');
    }


    public function destroy(Request $request, $id)
    {
        $slider = Slider::find($id);
        if (!$slider) {
            return back()->with(['error' => 'Slider tidak ditemukan']);
        }

        if ($slider->gambar_slider) {
            $filePath = public_path($slider->gambar_slider);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        $slider->delete();
        $role = $request->role;

        return back()->with(['success' => 'Slider berhasil dihapus']);
    }

    public function update(Request $request, $id)
    {
        $slider = Slider::find($id);
        if (!$slider) {
            return back()->with(['error' => 'Slider tidak ditemukan']);
        }
        $slider->judul_slider = $request->judul_slider;

        if ($request->hasFile('gambar_slider')) {
            $file = $request->file('gambar_slider');
            $rand = rand(10, 999);
            $fileName = $file->getClientOriginalName();
            $filePath = 'images/slider/' . $rand . $fileName;
            $file->move(public_path('images/slider'), $rand . $fileName);
            $slider->gambar_slider = $filePath;
        }

        $slider->is_active = $request->is_active;
        $slider->update();
        return redirect()->back()->with('success', 'Slider berhasil diperbarui');
    }
}
