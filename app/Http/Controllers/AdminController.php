<?php

namespace App\Http\Controllers;

use App\Jobs\ExportCategories;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function admin ()
    {
        return view('admin.admin');
    }

    public function users ()
    {
        $user = User::get();
        $data = [
            'title' => 'Список пользователей',
            'users' => $user
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
        $categories = Category::get();
        $data = [
            'title' => 'Список категорий',
        ];
        return view('admin.categories', compact('categories'), $data);
    }
    public function test ()
    {
        $testData = [
            'title' => 'Тестовая страничка с примерами',
            'number' => 2,
            'numbers' => [1, 3, 5, 7]
        ]; //передаем массив, во view можно потом обращаться к ключам как к переменным
        return view('admin.test', $testData);
    }
    public function enterAsUser($id)
    {
        Auth::loginUsingId($id);
        return redirect()->route('adminUsers');
    }
    public function exportCategories ()
    {
        ExportCategories::dispatch();
        session()->flash('startExportCategories');
        return back();
    }

    public function deleteCategory (Request $request) {
        $input = request()->all();
        $id = $input['id'];
        $category = Category::find($id);
        if ($category->products->count()) {
            session()->flash('canNotDeleteCategory');
        } else {
            $category->delete();
        };
        return back();
    }
}
