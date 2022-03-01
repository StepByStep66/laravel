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

class importProducts implements ShouldQueue
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
        $file = fopen('storage/app/public/products/importProducts.csv', 'r');

    $i = 0;
    while ($row = fgetcsv($file, 1000, ';')) {
        if ($i++ ==0) {
            $columns = $row;
            continue;
        }
        $data = array_combine($columns, $row);
        $categoryName = $data['category'];
        $category = Category::where('name', $categoryName)->first();
        
        $category_id = $category->id;
        $data['category_id'] = $category_id;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $productId = $data['id'];
        unset($data['category']);
        if ($product = Product::find($productId)) {
            $product->update([
                'name' => $data['name'],
                'description' => $data['description'],
                'picture' => $data['picture'],
                'price' => $data['price'],
                'category_id' => $category_id,
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at'],
            ]);
            $product->save();
        } else {   
            $product = new Product([
                'id' => $data['id'],
                'name' => $data['name'],
                'description' => $data['description'],
                'picture' => $data['picture'],
                'price' => $data['price'],
                'category_id' => $category_id,
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at'],
            ]);
            $product->save();
        }
    }         
    }
}
