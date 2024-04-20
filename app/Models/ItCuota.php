<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ItCuota extends Model
{
    use HasFactory;

    protected $table = 'it_cuota';
    protected $primaryKey = 'ct_codigo';
    public $guarded = ['ct_codigo'];
    public $timestamps = false;

    public function programacion(): BelongsTo
    {
        return $this->belongsTo(ItProgramacion::class, 'pg_codigo', 'pg_codigo');
    }

    public function pagoCuota(): HasOne
    {
        return $this->hasOne(ItPagoCuota::class, 'ct_codigo', 'ct_codigo');
    }

    
    
}
