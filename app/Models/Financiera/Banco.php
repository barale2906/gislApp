<?php

namespace App\Models\Financiera;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Banco extends Model
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

    //Buscar
    public function scopeBuscar($query, $item){
        $query->when($item ?? null, function($query, $item){
                    $query->where('nombre', 'like', "%".$item."%")
                        ->orwhere('banco', 'like', "%".$item."%")
                        ->orwhere('numero', 'like', "%".$item."%")
                        ->orwhere('tipo', 'like', "%".$item."%");
                });

    }
}
