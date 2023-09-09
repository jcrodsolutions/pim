<?php

namespace Database\Seeders;

use App\Models\Brand as Modelo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;

class BrandsSeeder extends Seeder {


    public function run(): void {
        $datos = [
            ['name' => 'Brand One', 'slug' => Str::slug('Brand One')],
            ['name' => 'Brand Two', 'slug' => Str::slug('Brand Two')],
            ['name' => 'Brand Three', 'slug' => Str::slug('Brand Three')],
        ];

        foreach ($datos as $value) {
            Modelo::create($value);
        }
    }
}
