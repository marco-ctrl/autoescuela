<?php

namespace App\Models\Sede1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Sede1\Inscripcion;
use App\Models\Sede1\Certificado;

class Evaluacion extends Model
{
    protected $connection = 'sede1';
    protected $table = 'evaluacion';
    protected $primaryKey = 'id_evaluacion';
    // public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id_evaluacion',
        'id_inscripcion',
        'id_evaluacion_teorica',
        'fecha',
        'tipo',
        'user_ins',
        'preguntas_incorrectas',	
        'preguntas_correctas',	
        'preguntas_totales',	
        'calificacion',
        'nro',	
        'aprobado',	
        'observacion',
        'user_cal',
        'consolidado'
    ];

    public function inscrpcion(): BelongsTo
    {
        return $this->belongsTo(Inscripcion::class, 'id_inscripcion', 'id_inscripcion');
    }

    public function evaluacionTeorica(): BelongsTo
    {
        return $this->belongsTo(Evaluacion::class, 'id_evaluacion_teorica', 'id_evaluacion');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'user_ins', 'id_usuario');
    }

    public function certificado(): HasOne
    {
        return $this->hasOne(Certificado::class, 'id_evaluacion', 'id_evaluacion');
    }
}
