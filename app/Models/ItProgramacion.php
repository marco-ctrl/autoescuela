<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItProgramacion extends Model
{
    use HasFactory;

    protected $table = 'it_programacion';
    protected $primaryKey = 'pg_codigo';
    public $guarded = ['pg_codigo'];
    public $timestamps = false;

    //Relacion uno a muchos inversa
    public function cuota(): HasMany
    {
        return $this->hasMany(ItCuota::class, 'pg_codigo', 'pg_codigo');
    }
}
