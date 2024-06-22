<?php

namespace App\Models\Sede1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $connection = 'sede1';
    protected $table = 'pago';
    protected $primaryKey = 'id_pago';
    public $timestamps = false;
    protected $fillable = [
        'id_pago',	
        'id_inscripcion',	
        'importe',	
        'saldo',	
        'fecha',	
        'nro_factura',	
        'nro_recibo',	
        'tipo',	
        'user_ins',	
        'user_del',	
        'date_ins',	
        'date_del',	
        'estado'
    ];

}
