<?php

namespace App\Models\Facturacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ListaEmpresa extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Relación uno a muchos inversa.
     * Lista a la que pertenece
     */
    public function listas() : BelongsTo
    {
        return $this->BelongsTo(Lista::class);
    }

    /**
     * Relación uno a muchos inversa.
     * Empresa a la que pertenece
     */
    public function empresas() : BelongsTo
    {
        return $this->BelongsTo(Empresa::class);
    }
}
