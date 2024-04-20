<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItInstitucion extends Model
{
    use HasFactory;

    protected $table = 'it_intitucion';
    protected $primaryKey = 'in_codigo';
    public $guarded = ['in_codigo'];
    public $timestamps = false;
}
