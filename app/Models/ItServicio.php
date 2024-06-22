<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItServicio extends Model
{
    use HasFactory;

    protected $table = 'it_servicio';
    protected $primaryKey = 'sv_codigo';
    public $guarded = ['sv_codigo'];
    public $timestamps = false;
}
