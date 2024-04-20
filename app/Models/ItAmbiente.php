<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItAmbiente extends Model
{
    use HasFactory;

    protected $table = 'it_ambiente';
    protected $primaryKey = 'am_codigo';
    public $guarded = ['am_codigo'];
    public $timestamps = false;
}
