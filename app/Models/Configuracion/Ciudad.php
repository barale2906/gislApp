<?php

namespace App\Models\Configuracion;

use App\Models\Diligencias\Diligencia;
use App\Models\Facturacion\Empresa;
use App\Models\Facturacion\Sucursal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ciudad extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Relación muchos a muchos.
     * ciudades con empresas
     */
    public function empresas() : BelongsToMany
    {
        return $this->BelongsToMany(Empresa::class);
    }

    /**
     * Relación uno a muchos.
     * Ciudad a sucursales
     */
    public function sucursales() : HasMany
    {
        return $this->hasMany(Sucursal::class);
    }

    /**
     * Relación uno a muchos.
     * Ciudad a diligencia destino
     */
    public function diligencias() : HasMany
    {
        return $this->hasMany(Diligencia::class);
    }
}
