<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Group;

class RotateGroups extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'groups:rotate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Obtener grupos de la cuenca Samaria
        $samariaGroups = Group::where('basin_id', 1)->get(); // Suponiendo que 1 es el ID de Samaria
        // Obtener grupos de la cuenca Tokio
        $tokioGroups = Group::where('basin_id', 2)->get(); // Suponiendo que 2 es el ID de Tokio

        // Rotar grupos de Samaria a Tokio
        foreach ($samariaGroups as $group) {
            $group->basin_id = 2; // Cambiar a Tokio
            $group->save();
        }

        // Rotar grupos de Tokio a Samaria
        foreach ($tokioGroups as $group) {
            $group->basin_id = 1; // Cambiar a Samaria
            $group->save();
        }

        $this->info('Grupos rotados exitosamente entre Samaria y Tokio.');
    }
}
