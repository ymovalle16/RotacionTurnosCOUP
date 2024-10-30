<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Basin;

class BasinNamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $BasinNames = [
            'Samaria',
            'Tokio',
        ];
        foreach ( $BasinNames as $names){
            Basin::create([
                'basin_name' => $names,
            ]);
        }
    }
}
