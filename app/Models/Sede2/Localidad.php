<?php

namespace App\Models\Sede2;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Localidad extends Model
{
    protected $connection = 'sede2';
    protected $table = 'localidad';
    protected $primaryKey = 'id_localidad';
    public $timestamps = false;

    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Localidad::class, 'id_padre', 'id_localidad');
    }
}
