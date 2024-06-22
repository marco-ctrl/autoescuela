<?php

namespace App\Models\Sede1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $connection = 'sede1';
    protected $table = 'usuario';
    public $timestamps = false;

    protected $fillable = ['id_usuario',
                            'nombres',
                            'apellidos',
                            'usuario'];
}
