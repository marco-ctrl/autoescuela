<?php

namespace App\Models\Sede2;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sede2\Inscripcion;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    protected $connection = 'sede2';
    protected $table = 'cliente';
    protected $primaryKey = 'id_cliente';
    public $timestamps = false;
    protected $fillable = ['id_cliente',	
                            'cod_cliente',	
                            'ci',	
                            'expedicion',	
                            'nombres',	
                            'paterno',	
                            'materno',	
                            'fec_nacimiento',	
                            'telefono',	
                            'celular',	
                            'email',	
                            'sexo',	
                            'direccion',	
                            'observacion',	
                            'foto',	
                            'estado'];

    /**
     * Get all of the comments for the Cliente
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function inscripciones(): HasMany
    {
        return $this->hasMany(Inscripcion::class, 'id_inscripcion', 'id_incripcion');
    }
}
