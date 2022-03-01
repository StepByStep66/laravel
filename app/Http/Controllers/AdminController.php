<?php

namespace App\Http\Controllers;

use App\Jobs\ExportCategories;
use App\Jobs\ExportProducts;
use App\Jobs\importProducts;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    public function productsFilter (Request $request) {
        $input = request()->all();
        $id = $input['category_id'];
        return redirect()->route('adminProducts', $id);   
    }

    public function products ($id)
    {        
        $category = Category::find($id);
        $categories = Category::get();
        $data = [
            'title' => 'Список продуктов',
            'categories' => $categories,
        ];   
        if (!$category) {        
            $data['oneCategory'] = null;
        }            
            $data['oneCategory'] = $category;
               
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

    public function exportProducts () {
        ExportProducts::dispatch();
        session()->flash('startExportProducts');
        return back();
    }

    public function importProducts () {
        $input = request()->all();
        request()->validate([
            'productFile' => 'required'
        ]);
        $file = $input['productFile'];

        if ($file) {
            $file->storeAs('public/products', 'importProducts.csv');
        };

        importProducts::dispatch();
        session()->flash('startImportProducts');
        return back();
    }

    public function getProductFile ()
    {
        $headers = [
            'Content-Type' => 'text/csv'
        ];
        return Storage::download('ExportProducts.csv', 'ExportProducts.csv', $headers);
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

    public function deleteProduct (Request $request) {
        $input = request()->all();
        $id = $input['id'];
        $product = Product::findOrFail($id);
        $product->delete();
        return back();
    }

    public function addProduct (Request $request) {
        $input = request()->all();

        request()->validate([
            'addName' => 'required',
            'addDescription' => 'required',
            'addToCategory' => 'required|numeric',
            'addPicture' => 'mimetypes:image/*|nullable',
            'addPrice' => 'required|numeric'
        ]);


        $name = $input['addName'];
        $description = $input['addDescription'];
        $picture = $input['addPicture'] ?? null;
        $price = $input['addPrice'];
        $category_id = $input['addToCategory'];
        $product = new Product([
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'category_id' => $category_id
        ]);

        if ($picture) {
            $ext = $picture->getClientOriginalExtension();
            $fileName = time() . rand(10000, 99999) . '.' . $ext;
            $picture->storeAs('public/products', $fileName);
            $product->picture = "products/$fileName";
        };

        $product->save();
        return back();
    }

    public function addCategory (Request $request) {
        $input = request()->all();

        request()->validate([
            'name' => 'required',
            'description' => 'required',
            'picture' => 'mimetypes:image/*|nullable',
        ]);

        $name = $input['name'];
        $description = $input['description'];
        $picture = $input['picture'] ?? null;
        $category = new Category([
            'name' => $name,
            'description' => $description,
        ]);

        if ($picture) {
            $ext = $picture->getClientOriginalExtension();
            $fileName = time() . rand(10000, 99999) . '.' . $ext;
            $picture->storeAs('public/categories', $fileName);
            $category->picture = "categories/$fileName";
        };

        $category->save();
        return back();
    }
}
