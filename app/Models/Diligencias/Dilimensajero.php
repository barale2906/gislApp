<?php

namespace App\Models\Diligencias;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dilimensajero extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Relación uno a muchos inversa
     * Asignación de diligencias al mensajero
     */
    public function diligencia() : BelongsTo
    {
        return $this->belongsTo(Diligencia::class);
    }

    /**
     * Relación uno a muchos inversa
     * Asignación de diligencias al mensajero
     */
    public function mensajero() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
