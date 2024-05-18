<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItPagoDocente extends Model
{
    use HasFactory;

    protected $table = 'it_pago_docente';
    protected $primaryKey = 'pd_codigo';
    public $guarded = ['pd_codigo'];

    protected $casts = [
        'pd_horas_pagadas' => 'array'
    ];

    protected $fillable = [
        "do_codigo",
		"pd_descripcion",
		"pd_horas_pagadas",
		"pd_monto_total",
		"pd_horas_pendiente",
		"pd_fecha_hora",
		"pd_created",
		"pd_updated",
		"us_codigo",
    ];
    
    public $timestamps = false;

    public function docente(): BelongsTo
    {
        return $this->belongsTo(ItDocente::class, 'do_codigo', 'do_codigo');
    }

}
