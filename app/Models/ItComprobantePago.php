<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItComprobantePago extends Model
{
    use HasFactory;

    protected $table = 'it_comprobante_pago';
    protected $primaryKey = 'cp_codigo';
    public $guarded = ['cp_codigo'];
    public $timestamps = false;
}
