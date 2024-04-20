<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItHorarioMatricula extends Model
{
    use HasFactory;

    protected $table = 'it_horario_matricula';
    protected $primaryKey = 'hm_codigo';
    public $guarded = ['hm_codigo'];
    public $timestamps = false;

    public function docente(): BelongsTo
    {
        return $this->belongsTo(ItDocente::class, 'do_codigo', 'do_codigo');
    }
    public function matricula(): BelongsTo
    {
        return $this->belongsTo(ItMatricula::class, 'ma_codigo', 'ma_codigo');
    }
}
