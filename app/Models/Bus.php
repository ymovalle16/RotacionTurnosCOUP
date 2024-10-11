<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;

    // Si el nombre de la tabla no sigue la convención plural
    protected $table = 'buses'; // Opcional, ya que Laravel lo deduce automáticamente

    // Definimos los campos que pueden ser asignados en masa
    protected $fillable = [
        'code',
        'status_id',
    ];

    // Si tienes alguna relación con otros modelos, puedes definirla aquí
    // Por ejemplo, si hay una relación con un modelo Bus:
    // public function buses()
    // {
    //     return $this->hasMany(Bus::class);
    // }
    public function statusBus() {
        return $this->belongsTo(StatusBus::class, 'status_id'); // Assuming the foreign key in your operators table is status_id
    }
}
