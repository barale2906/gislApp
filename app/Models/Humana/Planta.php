<?php

namespace App\Models\Humana;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Planta extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Relación uno a muchos inversa
     * Contrato con el que fue hecha la vinculación
     */
    public function contrato() : BelongsTo
    {
        return $this->belongsTo(Contrato::class);
    }

    /**
     * Relación uno a muchos inversa
     * Empleado
     */
    public function empleado() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación uno a muchos inversa
     * Salario aplicado
     */
    public function salario() : BelongsTo
    {
        return $this->belongsTo(Salario::class);
    }

     //Buscar
    public function scopeBuscar($query, $item){
        $query->when($item ?? null, function($query, $item){
                    $query->where('nombre', 'like', "%".$item."%")
                        ->orwhere('anio', 'like', "%".$item."%");
                });
    }
}
