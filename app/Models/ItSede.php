<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItSede extends Model
{
    use HasFactory;

    protected $table = 'it_sede';
    protected $primaryKey = 'se_codigo';
    public $guarded = ['se_codigo'];
    public $timestamps = false;
}
