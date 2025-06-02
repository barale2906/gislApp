<?php

namespace App\Models\Humana;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Salario extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Relación uno a muchos inversa
     * Tipo de contrato al que pertenece
     */
    public function contrato() : BelongsTo
    {
        return $this->belongsTo(Contrato::class);
    }

    /**
     * Relación uno a muchos.
     * Relación de salarios devengados con este salario
     */
    public function devengados() : HasMany
    {
        return $this->hasMany(Devengado::class);
    }

    //Buscar
    public function scopeBuscar($query, $item){
        $query->when($item ?? null, function($query, $item){
                    $query->where('basico', 'like', "%".$item."%")
                        ->orwhere('anio', 'like', "%".$item."%");
                });
    }
}
