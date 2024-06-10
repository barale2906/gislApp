<?php

namespace App\Models\Configuracion;

use App\Models\Diligencias\Diligencia;
use App\Models\Facturacion\Empresa;
use App\Models\Facturacion\Sucursal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ubica extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Relación uno a muchos inversa.
     * Ubicaciones con Usuarios
     */
    public function user() : BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    /**
     * Relación uno a muchos inversa.
     * Ubicaciones con empresas
     */
    public function empresa() : BelongsTo
    {
        return $this->BelongsTo(Empresa::class);
    }

    /**
     * Relación uno a muchos inversa.
     * Ubicaciones con sucursales
     */
    public function sucursal() : BelongsTo
    {
        return $this->BelongsTo(Sucursal::class);
    }

    /**
     * Relación uno a muchos inversa.
     * Ubicaciones con areas
     */
    public function area() : BelongsTo
    {
        return $this->BelongsTo(Area::class);
    }

    /**
     * Relación uno a muchos.
     * Ubicaciones con diligencias
     */
    public function diligencias() : HasMany
    {
        return $this->hasMany(Diligencia::class);
    }
}
