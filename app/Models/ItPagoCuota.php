<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItPagoCuota extends Model
{
    use HasFactory;

    protected $table = 'it_pago_cuota';
    protected $primaryKey = 'pc_codigo';
    public $guarded = ['pc_codigo'];
    public $timestamps = false;

    public function cuota(): BelongsTo
    {
        return $this->belongsTo(ItCuota::class, 'ct_codigo', 'ct_codigo');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'us_codigo', 'us_codigo');
    }
}
