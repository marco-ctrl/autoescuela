<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItComprobante extends Model
{
    use HasFactory;

    protected $table = 'it_comprobante';
    protected $primaryKey = 'co_codigo';
    public $guarded = ['co_codigo'];
    public $timestamps = false;
}
