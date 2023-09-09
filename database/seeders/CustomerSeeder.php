<?php

namespace Database\Seeders;

use App\Models\Customer as Modelo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $datos = [
            ['name'=>'Customer One', 'email'=>'customer.one@example.com','date_of_birth'=>'1970-01-01'],
            ['name'=>'Customer Two', 'email'=>'customer.two@example.com','date_of_birth'=>'1970-01-01'],
        ];
        
        foreach ($datos as $value) {
            Modelo::create($value);
        }
    }
}
