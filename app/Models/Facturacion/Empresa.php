<?php

namespace App\Models\Facturacion;

use App\Models\Configuracion\Ciudad;
use App\Models\Configuracion\Ubica;
use App\Models\Diligencias\Diligencia;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Empresa extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Relación muchos a muchos.
     * Usuarios con empresas
     */
    public function users() : BelongsToMany
    {
        return $this->BelongsToMany(User::class);
    }

    /**
     * Relación muchos a muchos.
     * ciudades con empresas
     */
    public function ciudades() : BelongsToMany
    {
        return $this->BelongsToMany(Ciudad::class);
    }

    /**
     * Relación uno a muchos.
     * sucursales a Empresas
     */
    public function sucursales() : HasMany
    {
        return $this->hasMany(Sucursal::class);
    }

    /**
     * Relación uno a muchos.
     * diligencias a Empresas
     */
    public function diligencias() : HasMany
    {
        return $this->hasMany(Diligencia::class);
    }

    /**
     * Relación uno a muchos.
     * Empresas con ubicaciones
     */
    public function ubicaciones() : HasMany
    {
        return $this->hasMany(Ubica::class);
    }

    /**
     * Relación uno a muchos.
     * listas de precio cargadas
     */
    public function listas() : HasMany
    {
        return $this->hasMany(ListaEmpresa::class);
    }

    /**
     * Relación uno a muchos.
     * facturas generadas
     */
    public function facturas() : HasMany
    {
        return $this->hasMany(Factura::class);
    }


    //Buscar
    public function scopeBuscar($query, $item){
        $query->when($item ?? null, function($query, $item){
                    $query->where('nit', 'like', "%".$item."%")
                        ->orwhere('name', 'like', "%".$item."%");
                });

    }
}
