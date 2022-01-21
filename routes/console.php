<?php

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

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

Artisan::command('parseEkatalog', function () {

    $search = 'intel+core';

    $url = "https://www.e-katalog.ru/ek-list.php?search_=$search&katalog_from_search_=186";

    $data = file_get_contents($url);

    $dom = new DomDocument();
    @$dom->loadHTMl($data);

    $xpath = new DOMXPath($dom);

    $totalProductsString = $xpath->query("//span[@class='t-g-q']")[0]->nodeValue ?? false;
    preg_match_all('/\d+/', $totalProductsString, $matches);     // регулярное выражение, ищет числа в строке
    $totalProducts = (int) $matches[0][0];

    $divs = $xpath->query("//div[@class='model-short-div list-item--goods   ']");
    $productsOnePage = $divs->length;
    $pages = ceil($totalProducts / $productsOnePage); //округление в большую сторону
    dd($pages);

    foreach ($divs as $div) {
        $a = $xpath->query("descendant::a[@class='model-short-title no-u no-u']", $div);
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
        dump("$name: $price");
    }
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
        //$category = Category::find(4);
        //$category->delete();
    // Category::where('id', 1)->delete();
    Category::whereNotNull('id')->delete();
});

Artisan::command('updateCategory', function () {
    Category::where('id', 2)->update([
    'name' => 'Процессоры'
    ]);
});

Artisan::command('createCategory', function () {
    $category = new Category([
        'name' => 'Видеокарты',
        'description' => 'Самые лучшие'
    ]);
    $category->save();
    dd($category);
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