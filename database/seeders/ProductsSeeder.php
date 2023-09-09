<?php

namespace Database\Seeders;

use App\Models\Product as Modelo;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;

class ProductsSeeder extends Seeder {

    public function run(): void {
        $datos = [
            ['brand_id'=> random_int(1, 3), 'name'=>'Product One', 'slug'=>Str::slug('Product One'), 'sku'=>fake()->ean13(), 'description'=>'Product One', 'quantity'=>1, 'price'=>fake()->randomNumber(3, true)/100],
            ['brand_id'=> random_int(1, 3), 'name'=>'Product Two', 'slug'=>Str::slug('Product Two'), 'sku'=>fake()->ean13(), 'description'=>'Product Two', 'quantity'=>1, 'price'=>fake()->randomNumber(3, true)/100],
            ['brand_id'=> random_int(1, 3), 'name'=>'Product Three', 'slug'=>Str::slug('Product Three'), 'sku'=>fake()->ean13(), 'description'=>'Product Three', 'quantity'=>1, 'price'=>fake()->randomNumber(3, true)/100],
            ['brand_id'=> random_int(1, 3), 'name'=>'Product Four', 'slug'=>Str::slug('Product Four'), 'sku'=>fake()->ean13(), 'description'=>'Product Four', 'quantity'=>1, 'price'=>fake()->randomNumber(3, true)/100],
            ['brand_id'=> random_int(1, 3), 'name'=>'Product Five', 'slug'=>Str::slug('Product Five'), 'sku'=>fake()->ean13(), 'description'=>'Product Five', 'quantity'=>1, 'price'=>fake()->randomNumber(3, true)/100],
        ];
        foreach ($datos as $value) {
            Modelo::create($value);
        }
    }
}
