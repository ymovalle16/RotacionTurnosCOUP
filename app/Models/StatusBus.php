<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusBus extends Model
{
    use HasFactory;
    // Si el nombre de la tabla no sigue la convención plural
    protected $table = 'statuses_bus'; // Opcional, ya que Laravel lo deduce automáticamente

    // Definimos los campos que pueden ser asignados en masa
    protected $fillable = [
       'id_status',
       'status_name',
    ];

   // Si tienes alguna relación con otros modelos, puedes definirla aquí
   // Por ejemplo, si hay una relación con un modelo Bus:
   // public function buses()
   // {
   //     return $this->hasMany(Bus::class);
   // }
   public function buses() {
       return $this->hasMany(Bus::class, 'id_status');
   }
}
