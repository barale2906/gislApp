<?php

namespace App\Models\Financiera;

use App\Models\Facturacion\Factura;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cartera extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Relación uno a muchos inversa.
     * Relación con la factura
     */
    public function factura() : BelongsTo
    {
        return $this->belongsTo(Factura::class);
    }

    //Buscar
    public function scopeBuscar($query, $item){
        $query->when($item ?? null, function($query, $item){
                    $query->where('cliente', 'like', "%".$item."%")
                        ->orwhere('nit', 'like', "%".$item."%");
                });

    }
}
