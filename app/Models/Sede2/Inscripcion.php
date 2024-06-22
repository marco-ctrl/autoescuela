<?php

namespace App\Models\Sede2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Sede2\Evaluacion;
use App\Models\Sede2\Cliente;
use App\Models\Sede2\Curso;
use App\Models\Sede2\Categoria;
use App\Models\Sede2\Localidad;

class Inscripcion extends Model
{
    protected $connection = 'sede2';
    protected $table = 'inscripcion';
    protected $primaryKey = 'id_inscripcion';
    public $timestamps = false;

    protected $fillable = [
        'id_inscripcion',
        'cod_inscripcion',
        'id_cliente',
        'fecha',
        'id_instructor',
        'id_localidad',
        'id_curso',
        'id_categoria',
        'fecha_ini',
        'fecha_fin',
        'precio',
        'user_ins',
        'estado',
    ];

    /**
     * Get the cliente that owns the Inscripcion
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente');
    }

    /**
     * Get all of the comments for the Inscripcion
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function evaluaciones(): HasMany
    {
        return $this->hasMany(Evaluacion::class, 'id_evaluacion', 'id_evaluacion');
    }

    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class, 'id_curso', 'id_curso');
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria');
    }

    public function localidad(): BelongsTo
    {
        return $this->belongsTo(Localidad::class, 'id_localidad', 'id_localidad');
    }
}
