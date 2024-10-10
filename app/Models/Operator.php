<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    use HasFactory;

     // Si el nombre de la tabla no sigue la convención plural
     protected $table = 'operators'; // Opcional, ya que Laravel lo deduce automáticamente

     // Definimos los campos que pueden ser asignados en masa
     protected $fillable = [
         'code',
         'name',
         'bus_code',
         'id_status',
     ];

    // Si tienes alguna relación con otros modelos, puedes definirla aquí
    // Por ejemplo, si hay una relación con un modelo Bus:
    // public function buses()
    // {
    //     return $this->hasMany(Bus::class);
    // }
    public function status() {
        return $this->belongsTo(Status::class, 'id_status'); // Assuming the foreign key in your operators table is status_id
    }

}
