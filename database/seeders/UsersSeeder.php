<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    private string $tabla = 'users';
    public function run(): void
    {
        $datos=[
            'name'=>'Julio Dev',
            'email' => 'julio@wjdevs.com',
            'password'=>'654321',
        ];
        
        User::create($datos);
    }
}
