<?php

namespace App\Models\Financiera;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Librodiario extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Relación uno a muchos inversa.
     * movimiento banco
     */
    public function banco() : BelongsTo
    {
        return $this->belongsTo(Banco::class);
    }

    /**
     * Relación uno a muchos inversa.
     * movimiento por concepto
     */
    public function concepto() : BelongsTo
    {
        return $this->belongsTo(Concepto::class);
    }

    //Buscar
    public function scopeBuscar($query, $item){
        $query->when($item ?? null, function($query, $item){
                    $query->where('comentario', 'like', "%".$item."%");
                });

    }

    //Movimientos por concepto
    public function scopeConcepto($query, $item){
        $query->when($item ?? null, function($query, $item){
            $query->where('concepto_id', $item);
        });
    }

    //Movimientos por banco
    public function scopeBanco($query, $item){
        $query->when($item ?? null, function($query, $item){
            $query->where('banco_id', $item);
        });
    }

    //Fecha movimiento
    public function scopeFecha($query, $lapso){
        $query->when($lapso ?? null, function($query, $lapso){
            $query->whereBetween('fecha', $lapso);
        });
    }

    //Saldos por banco
    public function scopeSaldo($query){
        $query->where('status',true);
    }
}
