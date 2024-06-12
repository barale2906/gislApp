<?php

namespace App\Models\Facturacion;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lista extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Relación uno a muchos.
     * detalles de la lista
     */
    public function detalles() : HasMany
    {
        return $this->hasMany(ListaDetalle::class);
    }

    /**
     * Relación uno a muchos.
     * clientes con esta lista
     */
    public function empresas() : HasMany
    {
        return $this->hasMany(ListaEmpresa::class);
    }


    //Buscar
    public function scopeBuscar($query, $item){
        $query->when($item ?? null, function($query, $item){
            $query->where('name', 'like', "%".$item."%")
                    ->orWhere('descripcion', 'like', "%".$item."%")
                    ->orwherehas('detalles', function($quer) use($item){
                        $quer->orwherehas('productos', function($quer) use($item){
                            $quer->where('productos.name', 'like', "%".$item."%");
                        });
                    });
        });
    }

    //Inicia
    public function scopeInicia($query, $lapso){
        $query->when($lapso ?? null, function($query, $lapso){
            $fecha1=Carbon::parse($lapso[0]);
            $fecha2=Carbon::parse($lapso[1]);
            $fecha2->addSeconds(86399);
            $query->whereBetween('inicia', [$fecha1 , $fecha2]);
        });
    }

    //Finaliza
    public function scopeFinaliza($query, $lapso){
        $query->when($lapso ?? null, function($query, $lapso){
            $fecha1=Carbon::parse($lapso[0]);
            $fecha2=Carbon::parse($lapso[1]);
            $fecha2->addSeconds(86399);
            $query->whereBetween('finaliza', [$fecha1 , $fecha2]);
        });
    }

}
