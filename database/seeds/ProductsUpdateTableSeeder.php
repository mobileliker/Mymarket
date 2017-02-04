<?php

use App\Product as Product;

use Illuminate\Database\Seeder;

class ProductsUpdateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $products = Product::select('id','products_group')->get(); 
       foreach ($products as $product) {
            if (empty($product->products_group)) {
                $ps = Product::find($product->id); 
                $ps->products_group = $product->id;
                $ps->save();
            }
       }
    }
}
