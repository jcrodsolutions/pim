<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['group_id'=>1,'store_code'=>'ST01','name'=>'Store One'],
            ['group_id'=>1,'store_code'=>'ST02','name'=>'Store Two'],
            ['group_id'=>1,'store_code'=>'ST03','name'=>'Store Three'],
            
            ['group_id'=>2,'store_code'=>'ST04','name'=>'Store Four'],
            ['group_id'=>2,'store_code'=>'ST05','name'=>'Store Five'],
        ];
        
        foreach ($data as $value) {
            Store::create($value);
        }
    }
}
