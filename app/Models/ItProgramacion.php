<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    public function matricula(): BelongsTo
    {
        return $this->belongsTo(ItMatricula::class, 'ma_codigo', 'ma_codigo');
    }

     public function servicio(): BelongsTo
    {
        return $this->belongsTo(ItServicio::class, 'sv_codigo', 'sv_codigo');
    }

    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(ItEstudiante::class, 'es_codigo', 'es_codigo');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'us_codigo', 'us_codigo');
    }

    public function usuarioEntregaCertificado():BelongsTo
    {
        return $this->belongsTo(User::class, 'ca_usuario_entrega', 'us_codigo');
    }
}
