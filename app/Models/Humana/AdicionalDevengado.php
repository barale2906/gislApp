<?php

namespace App\Models\Humana;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdicionalDevengado extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Relación uno a muchos inversa
     * Salario asignado.
     */
    public function adicional() : BelongsTo
    {
        return $this->belongsTo(Adicionale::class);
    }

    /**
     * Relación uno a muchos inversa
     * Registro devengado.
     */
    public function devengado() : BelongsTo
    {
        return $this->belongsTo(Devengado::class);
    }

}
