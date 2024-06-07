<?php

namespace Database\Seeders;

use App\Models\Product as Modelo;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;

class ProductsSeeder extends Seeder {

    // 'price'=>fake()->randomNumber(3, true)/100
    public function run(): void {
        $datos = [
            ['brand_id'=> random_int(1, 3), 'material'=>'10000001', 'name'=>'Product One', 'slug'=>Str::slug('Product One'), 'description'=>'Product One',  ],
            ['brand_id'=> random_int(1, 3), 'material'=>'10000002', 'name'=>'Product Two', 'slug'=>Str::slug('Product Two'), 'description'=>'Product Two',  ],
            ['brand_id'=> random_int(1, 3), 'material'=>'10000003', 'name'=>'Product Three', 'slug'=>Str::slug('Product Three'),  'description'=>'Product Three',  ],
            ['brand_id'=> random_int(1, 3), 'material'=>'10000004', 'name'=>'Product Four', 'slug'=>Str::slug('Product Four'), 'description'=>'Product Four',  ],
            ['brand_id'=> random_int(1, 3), 'material'=>'10000005', 'name'=>'Product Five', 'slug'=>Str::slug('Product Five'),  'description'=>'Product Five',  ],
        ];
        foreach ($datos as $value) {
            Modelo::create($value);
        }
    }
}
