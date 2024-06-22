<?php

namespace App\Models\Sede1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;
    protected $connection = 'sede1';
    protected $table = 'curso';
    protected $primaryKey = 'id_curso';
    public $timestamps = false;
    //protected $fillable = [
}
