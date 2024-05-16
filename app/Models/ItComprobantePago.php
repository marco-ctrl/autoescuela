<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItComprobantePago extends Model
{
    use HasFactory;

    protected $table = 'it_comprobante_pago';
    protected $primaryKey = 'cp_codigo';
    public $guarded = ['cp_codigo'];
    public $timestamps = false;

    public function pagoCuota(): BelongsTo
    {
        return $this->belongsTo(ItPagoCuota::class, 'pc_codigo', 'pc_codigo');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'us_codigo', 'us_codigo');
    }

}
