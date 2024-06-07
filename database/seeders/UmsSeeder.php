<?php

namespace Database\Seeders;

use App\Models\Um;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UmsSeeder extends Seeder {

    public function run(): void {
        $data = [
            ['um' => 'BAG', 'description' => 'BAG',],
            ['um' => 'CJ', 'description' => 'CJ',],
            ['um' => 'CS', 'description' => 'CS',],
            ['um' => 'DZ', 'description' => 'DZ',],
            ['um' => 'EA', 'description' => 'EA',],
            ['um' => 'KG', 'description' => 'KG',],
            ['um' => 'KI', 'description' => 'KI',],
            ['um' => 'LB', 'description' => 'LB',],
            ['um' => 'M', 'description' => 'M',],
            ['um' => 'SPK', 'description' => 'SPK',],
            ['um' => 'ST', 'description' => 'ST',],
        ];
        foreach ($data as $value) {
            Um::create($value);
        }
    }
}
