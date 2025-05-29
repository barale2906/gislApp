<?php

namespace App\Models\Humana;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contrato extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Relación uno a muchos.
     * salarios con este tipo de contrato
     */
    public function salarios() : HasMany
    {
        return $this->hasMany(Salario::class);
    }

    /**
     * Relación uno a muchos inversa
     * persona que aprobo
     */
    public function aprobado() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    //Buscar
    public function scopeBuscar($query, $item){
        $query->when($item ?? null, function($query, $item){
                    $query->where('nombre', 'like', "%".$item."%")
                        ->orwhere('descripcion', 'like', "%".$item."%");
                });

    }
}
