<?php

namespace App\Models\Facturacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Factura extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Relación uno a muchos.
     * Detalles de la factura
     */
    public function detalles() : HasMany
    {
        return $this->hasMany(FacturaDetalle::class);
    }

    /**
     * Relación uno a muchos inversa.
     * con que lista de precios se genero
     */
    public function lista() : BelongsTo
    {
        return $this->belongsTo(Lista::class);
    }

    /**
     * Relación uno a muchos inversa.
     * A que empresa pertenece
     */
    public function empresa() : BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }


}
