<?php

namespace App\Jobs;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExportProducts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $products = Product::get()->toArray();
        $file = fopen('storage/app/ExportProducts.csv', 'w');
        $columns = [
            'id',
            'name',
            'description',
            'picture',
            'price',
            'category',
            'created_at',
            'updated_at',
        ];
        fputcsv($file, $columns, ';');
        foreach ($products as $product) {
            //$category['name'] = iconv('utf-8', 'windows-1251/IGNORE', $category['name']);
            //$category['description'] = iconv('utf-8', 'windows-1251/IGNORE', $category['description']);
            //$category['picture'] = iconv('utf-8', 'windows-1251/IGNORE', $category['picture']);
            $category_id = $product['category_id'];
            $category = Category::find($category_id);
            $productToExport = [
                'id' => $product['id'],
                'name' => $product['name'],
                'description' => $product['description'],
                'picture' => $product['picture'],
                'price' => $product['price'],
                'category'=> $category->name,
                'created_at' => $product['created_at'],
                'updated_at' => $product['updated_at']
            ];
            fputcsv($file, $productToExport, ';');
        }
        fclose($file);
    }
}