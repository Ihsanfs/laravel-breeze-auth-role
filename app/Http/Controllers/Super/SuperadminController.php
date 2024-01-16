<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuperadminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }
}
