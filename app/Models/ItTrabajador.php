<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItTrabajador extends Model
{
    use HasFactory;

    protected $table = 'it_trabajador';
    protected $primaryKey = 'tr_codigo';
    public $guarded = ['tr_codigo'];
    public $timestamps = false;

    public function itUsuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'us_codigo', 'id');
    }
}