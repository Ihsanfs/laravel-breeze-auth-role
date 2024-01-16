<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class StudentsController extends Controller
{
    public function index()
    {
        return view('admin.students');
    }
}
