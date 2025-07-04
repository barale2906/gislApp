<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Configuracion\Ubica;
use App\Models\Diligencias\Dilifotos;
use App\Models\Diligencias\Dilimensajero;
use App\Models\Facturacion\Empresa;
use App\Models\Facturacion\Factura;
use App\Models\Humana\Contrato;
use App\Models\Humana\Devengado;
use App\Models\Humana\Inasistencia;
use App\Models\Humana\Planta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'diaria',
        'status',
        'rol_id',
        'empresa_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Relación uno a muchos.
     * Usuarios con ubicaciones
     */
    public function ubicaciones() : HasMany
    {
        return $this->hasMany(Ubica::class);
    }

    /**
     * Relación uno a muchos.
     * Usuarios crea factura
     */
    public function facturas() : HasMany
    {
        return $this->hasMany(Factura::class);
    }

    /**
     * Relación muchos a muchos.
     * Usuarios con empresas
     */
    public function empresas() : BelongsToMany
    {
        return $this->BelongsToMany(Empresa::class);
    }

    /**
     * Relación muchos a muchos.
     * Diligencias con users
     */
    public function mensajeros() : HasMany
    {
        return $this->hasMany(Dilimensajero::class);
    }

    /**
     * Relación uno a muchos.
     * fotografos mensajeros
     */
    public function fotografos() : HasMany
    {
        return $this->hasMany(Dilifotos::class);
    }

    /**
     * Relación uno a muchos.
     * Contratos aprobados con users
     */
    public function aprobados() : HasMany
    {
        return $this->hasMany(Contrato::class);
    }

    /**
     * Relación uno a muchos.
     * Empleado Inasistente
     */
    public function inasistencias() : HasMany
    {
        return $this->hasMany(Inasistencia::class);
    }

    /**
     * Relación uno a muchos.
     * RElación de salarios devengados
     */
    public function devengados() : HasMany
    {
        return $this->hasMany(Devengado::class);
    }

    /**
     * Relación uno a muchos.
     * Personas activas en el sistema
     */
    public function plantas() : HasMany
    {
        return $this->hasMany(Planta::class);
    }


}
