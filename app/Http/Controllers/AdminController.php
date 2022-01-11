<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function users ()
    {
        return view('admin.users');
    }
    public function products ()
    {
        return view('admin.products');
    }
    public function categories ()
    {
        return view('admin.categories');
    }
}
