<?php

namespace App\Models\Facturacion;

use App\Models\Configuracion\Area;
use App\Models\Configuracion\Ciudad;
use App\Models\Configuracion\Ubica;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sucursal extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Relación uno a muchos inversa.
     * Sucursal con empresas
     */
    public function empresa() : BelongsTo
    {
        return $this->BelongsTo(Empresa::class);
    }

    /**
     * Relación uno a muchos inversa.
     * Sucursal con ciudad
     */
    public function ciudad() : BelongsTo
    {
        return $this->BelongsTo(Ciudad::class);
    }

    /**
     * Relación muchos a muchos.
     * Aras con sucursales
     */
    public function areas() : BelongsToMany
    {
        return $this->BelongsToMany(Area::class);
    }

    /**
     * Relación uno a muchos.
     * Sucursales con ubicaciones
     */
    public function ubicaciones() : HasMany
    {
        return $this->hasMany(Ubica::class);
    }


}
