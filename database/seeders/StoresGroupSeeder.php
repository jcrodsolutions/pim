<?php

namespace Database\Seeders;

use App\Models\StoresGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoresGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['group_code'=>'GR01', 'name'=>'First Group'],
            ['group_code'=>'GR02', 'name'=>'Second Group'],
            ['group_code'=>'GR03', 'name'=>'Third Group'],
        ];
        
        foreach ($data as $value) {
            StoresGroup::create($value);
        }
    }
}
