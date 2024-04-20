<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItPabellon extends Model
{
    use HasFactory;

    protected $table = 'it_pabellon';
    protected $primaryKey = 'pa_codigo';
    public $guarded = ['pa_codigo'];
    public $timestamps = false;
}
