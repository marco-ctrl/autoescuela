<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItMatricula extends Model
{
    use HasFactory;

    protected $table = 'it_matricula';
    protected $primaryKey = 'ma_codigo';
    public $guarded = ['ma_codigo'];
    public $timestamps = false;

    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(ItEstudiante::class, 'es_codigo', 'es_codigo');
    }

    public function curso(): BelongsTo
    {
        return $this->belongsTo(ItCurso::class, 'cu_codigo', 'cu_codigo');
    }

    public function ambiente(): BelongsTo
    {
        return $this->belongsTo(ItAmbiente::class, 'am_codigo', 'am_codigo');
    }

    public function sede(): BelongsTo
    {
        return $this->belongsTo(ItSede::class, 'se_codigo', 'se_codigo');
    }

    public function yearSeccion(): BelongsTo
    {
        return $this->belongsTo(ItYearSeccion::class, 'ys_codigo', 'ys_codigo');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'us_codigo_create', 'us_codigo');
    }
}
