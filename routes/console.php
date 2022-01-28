<?php

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('importCategoriesFromFile', function() {
    
    $file = fopen('categories.csv', 'r');

    $i = 0;
    $insert = [];
    while ($row = fgetcsv($file, 1000, ';')) {
        if ($i++ ==0) {
            //$bom = pack('H*','EFBBBF'); удаление не печатаемого символа при сохранении файла в Excel
            //$row = preg_replace("/^$bom/", $row);
            $columns = $row;
            continue;
        }
        $data = array_combine($columns, $row);
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $insert[] = $data;

    }
    Category::insert($insert);
});

Artisan::command('parseEkatalog', function () {

    $url = "https://www.e-katalog.ru/ek-list.php?katalog_=189&search_=rtx+3090";

    $data = file_get_contents($url);

    $dom = new DomDocument();
    @$dom->loadHTMl($data);

    $xpath = new DOMXPath($dom);

    $totalProductsString = $xpath->query("//span[@class='t-g-q']")[0]->nodeValue ?? false;
    preg_match_all('/\d+/', $totalProductsString, $matches);     // регулярное выражение, ищет числа в строке
    $totalProducts = (int) $matches[0][0];

    $divs = $xpath->query("//div[contains(@class, 'model-short-div list-item--goods') or contains(@class, 'model-short-div list-item--offers')]");
    $productsOnePage = $divs->length;
    $pages = (int) ceil($totalProducts / $productsOnePage);
    $products = [];

    for ($i = 0; $i < $pages; $i++) {

        $nextUrl = $url . "&page_=$i";
        $data = file_get_contents($nextUrl);

        $dom = new DomDocument();
        @$dom->loadHTMl($data);

        $xpath = new DOMXPath($dom);

        $divs = $xpath->query("//div[contains(@class, 'model-short-div list-item--goods') or contains(@class, 'model-short-div list-item--offers')]");

        foreach ($divs as $div) {
            $a = $xpath->query("descendant::a[contains(@class, 'model-short-title no-u') or contains(text(), 'Видеокарта')]", $div);
            $name = $a[0]->nodeValue;

            $price = 0;
            $ranges = $xpath->query("descendant::div[@class='model-price-range']", $div);
            if ($ranges->length == 1) {
                foreach ($ranges[0]->childNodes as $child) {
                    if ($child->nodeName == 'a') {
                        $price = 'от ' . $child->nodeValue;
                    }
                }
            }

            $ranges = $xpath->query("descendant::div[@class='pr31 ib']", $div);
            if ($ranges->length == 1) {
                $price = $ranges[0]->nodeValue;
            }
            $products[] = [
                'name' => $name,
                'price' => $price
            ];
        }
    }
    $file = fopen('videocards.csv', 'w');
    foreach ($products as $product) {
        fputcsv($file, $product, ';');
    }
    fclose($file);
});

Artisan::command('massCategoriesInsert', function () {
    $categories = [
        [
            'name' => 'Видокарты',
            'description' => 'Описание',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'name' => 'Чипы',
            'description' => 'Японские',
            'updated_at' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s')
        ]
        ];
        Category::insert($categories);
});

Artisan::command('deleteCategory', function () {
        Auth::loginUsingId(1);
        // Category::find(22)->delete(); //работает с обсервером
        Category::where('id', '23')->first()->delete(); 
        // where возвращает маасив,а не модель, это не попадет в логи.
        // При массовом удалении надо писать лог на месте 
        // (с first()-норм, возвращается модель)
        
        // Category::whereNotNull('id')->delete();
});

Artisan::command('queryBuilder', function () {
    $data = DB::table('categories as c')
        ->select(
            'c.id',
            'c.name',
            'c.description'
        )
        ->where('name', 'Процессоры')
        ->first();
    
    // dd($data);
            
    $data = DB::table('categories as c')
    ->select(
        'c.name',
        DB::raw('count(p.id) as product_quantity'),
        DB::raw('sum(p.price) as priceAmount')
    )
    ->leftJoin('products as p', function ($join) {
        $join->on( 'c.id', 'p.category_id');
    })
        ->groupBy('c.id')
        ->get();

    // dd($data);

    DB::table('categories')
        ->orderBy('id')
        ->chunk(1, function ($categories) { // разбивает вывод на чанки
            dump($categories->count());
        });
});

Artisan::command('updateCategory', function () {

    Auth::loginUsingId(1);
    Category::where('id', 13)->first()->update([
    'name' => 'Процессоры'
    ]);
});

Artisan::command('createCategory', function () {
    $category = new Category([
        'name' => 'Корпуса77',
        'description' => 'ATX'
    ]);
    $category->save();
});

Artisan::command('inspire', function () {

    $user = User::find(1);
    $addresses = $user->addresses->filter(function ($address) {
        return $address->main;
    })->pluck('address');
    
    $addresses = $user->addresses()->where('main', 1)->get();
    dd($addresses);

    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');