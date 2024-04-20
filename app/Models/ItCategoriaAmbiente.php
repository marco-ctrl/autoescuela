<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItCategoriaAmbiente extends Model
{
    use HasFactory;

    protected $table = 'it_categoria_ambiente';
    protected $primaryKey = 'ca_codigo';
    public $guarded = ['ca_codigo'];
    public $timestamps = false;
}
