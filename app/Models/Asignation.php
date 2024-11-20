<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignation extends Model
{
    use HasFactory;

    // Si el nombre de la tabla no sigue la convención plural
    protected $table = 'asignations'; // Opcional, ya que Laravel lo deduce automáticamente

    // Definimos los campos que pueden ser asignados en masa
    protected $fillable = [
        'tab_id',
        'operator_id',
    ];

    // Relación con el modelo Operator
    public function operator()
    {
        return $this->belongsTo(Operator::class);
    }

    // Relación con el modelo NumTable
    public function numTable()
    {
        return $this->belongsTo(NumTable::class);
    }
}
