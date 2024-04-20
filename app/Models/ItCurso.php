<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItCurso extends Model
{
    use HasFactory;

    protected $table = 'it_curso';
    protected $primaryKey = 'cu_codigo';
    public $guarded = ['cu_codigo'];
    public $timestamps = false;
}
