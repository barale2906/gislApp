<?php

namespace App\Models\Financiera;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Concepto extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Relación uno a muchos.
     * Movimientos generados
     */
    public function librodiarios() : HasMany
    {
        return $this->hasMany(Librodiario::class);
    }

    /**
     * Relación uno a muchos.
     * cuentas por pagar
     */
    public function cuentaspagar() : HasMany
    {
        return $this->hasMany(Cuentaspagar::class);
    }

    //Buscar
    public function scopeBuscar($query, $item){
        $query->when($item ?? null, function($query, $item){
                    $query->where('concepto', 'like', "%".$item."%");
                });

    }
}
