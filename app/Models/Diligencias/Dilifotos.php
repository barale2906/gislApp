<?php

namespace App\Models\Diligencias;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dilifotos extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Relación uno a muchos inversa
     * fotos de las diligencias
     */
    public function diligencias() : BelongsTo
    {
        return $this->belongsTo(Diligencia::class);
    }

    /**
     * Relación uno a muchos inversa
     * Usuarios que cargan las fotos
     */
    public function usuario() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
