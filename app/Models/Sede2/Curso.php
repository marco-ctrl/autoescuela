<?php

namespace App\Models\Sede2;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;
    protected $connection = 'sede2';
    protected $table = 'curso';
    protected $primaryKey = 'id_curso';
    public $timestamps = false;
    //protected $fillable = [
}
