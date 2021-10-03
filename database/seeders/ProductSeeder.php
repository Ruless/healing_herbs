<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->truncate(); // Перед заполнением данных удаляем предыдущие
        //
        $contents = file_get_contents(__DIR__ . '/json/product.json');
        foreach (json_decode($contents, false) as $line) {
            $product = new Product((array)$line);
            $product->save();
        }
    }
}
