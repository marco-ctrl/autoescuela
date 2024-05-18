<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItProducto extends Model
{
    use HasFactory;

    protected $table = 'it_producto';
    protected $primaryKey = 'pr_codigo';
    public $guarded = ['pd_codigo'];

    protected $fillable = [
        "pr_descripcion",
        "pr_tipo",
        "pr_barra",
        "pr_estado",
        "pr_created",
        "pr_tipo_producto",
        "pr_updated",
    ];

    public $timestamps = false;
}
