<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItYearSeccion extends Model
{
    use HasFactory;

    protected $table = 'it_year_seccion';
    protected $primaryKey = 'ys_codigo';
    public $guarded = ['ys_codigo'];
    public $timestamps = false;
}
