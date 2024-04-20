<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItEstudiante extends Model
{
    use HasFactory;

    public $guarded = ['es_codigo'];
    protected $table = 'it_estudiante';
    protected $primaryKey = 'es_codigo';
    public $timestamps = false;

    public function usuarioCreated(): BelongsTo
    {
        return $this->belongsTo(User::class, 'us_codigo_create', 'us_codigo');
    }

}
