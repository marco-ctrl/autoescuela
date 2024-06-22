<?php

namespace App\Models\Sede1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Sede1\Evaluacion;
use App\Models\Sede1\Cliente;
use App\Models\Sede1\Curso;
use App\Models\Sede1\Categoria;
use App\Models\Sede1\Localidad;
use App\Models\Sede1\Usuario;
use App\Models\Sede1\Pago;

class Inscripcion extends Model
{
    protected $connection = 'sede1';
    protected $table = 'inscripcion';
    public $timestamps = false;
    protected $primaryKey = 'id_inscripcion';

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

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'user_ins', 'id_usuario');
    }

    public function pago(): HasMany
    {
        return $this->hasMany(Pago::class, 'id_inscripcion', 'id_inscripcion');
    }
}
