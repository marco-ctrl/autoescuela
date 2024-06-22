<?php

namespace App\Models\Sede2;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sede2\Inscripcion;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    use HasFactory;
    protected $connection = 'sede2';
    protected $table = 'categoria';
    public $timestamps = false;
    protected $primaryKey = 'id_categoria';
    // protected $keyType = 'string';
    protected $fillable = ['id_categoria',
        'id_categoria',
        'cod_categoria',
        'descripcion',
        'edad_minima',
        'edad_maxima',
        'total_preguntas',
        'orden',
        'estado'
    ];

    public function inscripciones(): HasMany
    {
        return $this->hasMany(Inscripcion::class, 'id_inscripcion', 'id_inscripcion');
    }
}
