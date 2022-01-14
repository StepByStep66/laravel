<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function admin ()
    {
        return view('admin.admin');
    }

    public function users ()
    {
        $data = [
            'title' => 'Список пользователей',
        ];
        return view('admin.users', $data);
    }
    public function products ()
    {
        $data = [
            'title' => 'Список продуктов',
        ];
        return view('admin.products', $data);
    }
    public function categories ()
    {
        $data = [
            'title' => 'Список категорий',
        ];
        return view('admin.categories', $data);
    }
    public function test ()
    {
        $testData = [
            'title' => 'Тестовая страничка с примерами',
            'number' => 2,
            'numbers' => [1, 3, 5, 7]
        ];
        return view('admin.test', $testData);
    }
}
