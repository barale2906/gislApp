<?php

namespace App\Models\Facturacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ListaDetalle extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Relación uno a muchos inversa.
     * productos por lista
     */
    public function producto() : BelongsTo
    {
        return $this->BelongsTo(Producto::class);
    }

    /**
     * Relación uno a muchos inversa.
     * item por lista
     */
    public function listas() : BelongsTo
    {
        return $this->BelongsTo(Lista::class);
    }
}
