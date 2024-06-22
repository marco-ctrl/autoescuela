<?php

namespace App\Models\Sede1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Localidad extends Model
{
    protected $connection = 'sede1';
    protected $table = 'localidad';
    protected $primaryKey = 'id_localidad';
    public $timestamps = false;
    protected $fillable = [
        'id_localidad',
        'nombre',
        'nivel',
        'id_padre',
    ];

    /**
     * Get the user that owns the Localidad
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Localidad::class, 'id_padre', 'id_localidad');
    }
}
