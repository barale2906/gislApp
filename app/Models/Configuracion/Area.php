<?php

namespace App\Models\Configuracion;

use App\Models\Facturacion\Sucursal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Area extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Relación muchos a muchos.
     * Areas con sucursales
     */
    public function sucursales() : BelongsToMany
    {
        return $this->BelongsToMany(Sucursal::class);
    }

    /**
     * Relación uno a muchos.
     * áreass con ubicaciones
     */
    public function ubicaciones() : HasMany
    {
        return $this->hasMany(Ubica::class);
    }
}
