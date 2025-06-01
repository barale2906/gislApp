<?php

namespace App\Models\Humana;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inasistencia extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Relación uno a muchos inversa
     * Empleado que inasistio
     */
    public function inasistente() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    //Buscar
    public function scopeBuscar($query, $item){
        $query->when($item ?? null, function($qu, $item){
                    $qu->where('nombre', 'like', "%".$item."%")
                            ->orwhere('aprobo', 'like', "%".$item."%");
                });

    }
}
