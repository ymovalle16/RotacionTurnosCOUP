<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Status;


class TypeStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $TypeStatus = [
            'Disponible',
            'Descanso',
            'Enfermo',
            'Calamidad Doméstica',
            'Incapacitado',
            'Permiso',
            'Vacaciones',
            'Suspendido',
            'Retirado'
        ];
        foreach ( $TypeStatus as $statuses){
            Status::create([
                'status_name' => $statuses,
            ]);
        }
    }
}
