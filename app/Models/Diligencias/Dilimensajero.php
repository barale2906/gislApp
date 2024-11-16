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

    public function scopeBuscar($query, $item){
        $query->when($item ?? null, function($query, $item){
            $query->wherehas('diligencia', function($query) use($item){
                    $query->where('diligencias.identificador', 'like', "%".$item."%")
                        ->orwhere('diligencias.name_dest', 'like', "%".$item."%")
                        ->orwhere('diligencias.direccion_dest','like', "%".$item."%")
                        ->orwhere('diligencias.descripcion','like', "%".$item."%")
                        ->orWherehas('ubica', function($query) use($item) {
                            $query->wherehas('user', function($query) use($item){
                                $query->where('users.name', 'like', "%".$item."%");
                            });
                        })
                        ->orWherehas('empresa', function($query) use($item) {
                            $query->where('empresas.name', 'like', "%".$item."%");
                        });
                });
            });

    }

    public function scopeEntregado($query, $lapso){
        $query->when($lapso ?? null, function($query, $lapso){
            $query->wherehas('diligencia', function($query) use($lapso){
                $query->whereBetween('diligencias.fecha_recepcion', $lapso);
            });
        });
    }
}
