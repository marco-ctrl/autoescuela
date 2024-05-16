<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'it_usuario';
    protected $primaryKey = 'us_codigo';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'us_correo',
        'us_tipo',
        'us_password',
        'us_created',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'us_password',
        'us_created',
        'us_token',
        'us_refresh_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    public function trabajador(): HasOne
    {
        return $this->hasOne(ItTrabajador::class, 'us_codigo', 'us_codigo');
    }

    public function estudiante(): HasOne
    {
        return $this->hasOne(ItEstudiante::class, 'us_codigo', 'us_codigo');
    }

    public function docente(): HasOne
    {
        return $this->hasOne(ItDocente::class, 'us_codigo', 'us_codigo');
    }
}
