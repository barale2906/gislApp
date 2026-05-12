<?php

namespace App\Models\Facturacion;

use App\Models\Diligencias\Diligencia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FacturaDetalle extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Relación uno a muchos inversa.
     * a que factura pertenece
     */
    public function factura() : BelongsTo
    {
        return $this->belongsTo(Factura::class);
    }

    /**
     * Relación uno a muchos inversa.
     * Diligencia asociada (cuando el detalle se generó desde una diligencia).
     * La columna `diligencia` almacena el id de la diligencia.
     */
    public function diligenciaInfo() : BelongsTo
    {
        return $this->belongsTo(Diligencia::class, 'diligencia');
    }
}
