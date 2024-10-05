<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        User::create([
            'name' => 'Gustavo Adolfo Arias',
            'identification' => '999999999',
            'password' => Hash::make('admin123'),
            'created_at' => now(),
            'updated_at' => now(),
            
        ]);
    }
}
