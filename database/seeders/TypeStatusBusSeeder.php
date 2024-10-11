<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StatusBus;

class TypeStatusBusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $TypeStatusBus = [
            'Disponible',
            'Asignada',
            'Varada',
            'Mantenimiento',
            'Patios'
        ];
        foreach ( $TypeStatusBus as $statuses_bus){
            StatusBus::create([
                'status_name' => $statuses_bus,
            ]);
        }
    }
}
