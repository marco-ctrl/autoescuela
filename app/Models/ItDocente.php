<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItDocente extends Model
{
    use HasFactory;

    protected $table = 'it_docente';
    protected $primaryKey = 'do_codigo';
    public $guarded = ['do_codigo'];
    public $timestamps = false;

    public function horarioMatriculas(): HasMany
    {
        return $this->hasMany(ItHorarioMatricula::class, 'do_codigo', 'do_codigo');
    }
}
