<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItComprobante extends Model
{
    use HasFactory;

    protected $table = 'it_comprobante';
    protected $primaryKey = 'cb_codigo';
    public $guarded = ['cb_codigo'];
    public $timestamps = false;
}
