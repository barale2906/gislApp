<?php

namespace App\Models\Humana;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Devengado extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Relación uno a muchos inversa
     * Empleado a quien se le paga.
     */
    public function empleado() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación uno a muchos.
     * Detalles de los adicionales registrados por usuario
     */
    public function adiciodevengados() : HasMany
    {
        return $this->hasMany(AdicionalDevengado::class);
    }

    /**
     * Relación uno a muchos inversa
     * Salario asignado.
     */
    public function salario() : BelongsTo
    {
        return $this->belongsTo(Salario::class);
    }

    //Buscar
    public function scopeBuscar($query, $item){
        $query->when($item ?? null, function($qu, $item){
                    $qu->where('nombre', 'like', "%".$item."%")
                            ->orwhere('aprobo', 'like', "%".$item."%");
                });
    }
}
