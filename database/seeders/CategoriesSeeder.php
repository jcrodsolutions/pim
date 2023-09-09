<?php

namespace Database\Seeders;

use App\Models\Category as Modelo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $datos = [
            ['name' => 'Category One', 'slug' => Str::slug('Category One')],
            ['name' => 'Category Two', 'slug' => Str::slug('Category Two')],
            ['name' => 'Category Three', 'slug' => Str::slug('Category Three')],
        ];
        foreach ($datos as $value) {
            Modelo::create($value);
        }
    }
}
