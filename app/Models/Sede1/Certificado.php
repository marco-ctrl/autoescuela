<?php

namespace App\Models\Sede1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Certificado extends Model
{
    use HasFactory;
    protected $connection = 'sede1';
    protected $table = 'certificado';
    protected $primaryKey = 'id_certificado';
    public $timestamps = false;

    protected $fillable = ['id_certificado', 
                            'id_evaluacion', 
                            'gestion', 
                            'numero_correlativo',
                            'nrocertman'];

    /**
     * Get the user that owns the Certificado
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function evaluacion(): BelongsTo
    {
        return $this->belongsTo(Evaluacion::class, 'id_evaluacion', 'id_evaluacion');
    }
}
