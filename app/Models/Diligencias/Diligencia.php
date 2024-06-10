<?php

namespace App\Models\Diligencias;

use App\Models\Configuracion\Ciudad;
use App\Models\Configuracion\Ubica;
use App\Models\Facturacion\Empresa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Diligencia extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Relación uno a muchos inversa
     * Diligencias con Ubicaciones
     */
    public function ubica() : BelongsTo
    {
        return $this->belongsTo(Ubica::class);
    }

    /**
     * Relación uno a muchos inversa
     * Diligencias con empresas
     */
    public function empresa() : BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    /**
     * Relación uno a muchos inversa
     * Diligencias con ciudades
     */
    public function ciudad() : BelongsTo
    {
        return $this->belongsTo(Ciudad::class);
    }

    /**
     * Relación muchos a muchos.
     * Diligencias con users
     */
    public function mensajeros() : BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    //Salen
    public function scopeMias($query,$user){
        $query->wherehas('ubica', function($query) use($user){
            $query->where('ubicas.user_id', $user);
        });
    }

    public function scopeArea($query,$ubica){
        $query->wherehas('ubica', function($query) use($ubica){
            $query->where('ubicas.empresa_id', $ubica->empresa_id)
                    ->where('ubicas.sucursal_id', $ubica->sucursal_id)
                    ->where('ubicas.area_id', $ubica->area_id);
        });
    }

    //Llegan
    public function scopeMiallega($query,$user){
        $query->where('dest_id', $user);
    }

    public function scopeAreallega($query,$ubica){
        $query->where('sucursal_dest_id', $ubica->sucursal_id)
                ->where('area_dest_id', $ubica->area_id);
    }

    //Buscar
    public function scopeBuscar($query, $item){
        $query->when($item ?? null, function($query, $item){
                    $query->where('id', 'like', "%".$item."%")
                        ->orwhere('name_dest', 'like', "%".$item."%")
                        ->orwhere('direccion_dest','like', "%".$item."%")
                        ->orwhere('descripcion','like', "%".$item."%")
                        ->orWherehas('ubica', function($query) use($item) {
                            $query->wherehas('user', function($query) use($item){
                                $query->where('users.name', 'like', "%".$item."%");
                            });
                        });
                });

    }

    public function scopeCreado($query, $lapso){
        $query->when($lapso ?? null, function($query, $lapso){
            $fecha1=Carbon::parse($lapso[0]);
            $fecha2=Carbon::parse($lapso[1]);
            $fecha2->addSeconds(86399);
            $query->whereBetween('created_at', [$fecha1 , $fecha2]);
        });
    }

    public function scopeEntregado($query, $lapso){
        $query->when($lapso ?? null, function($query, $lapso){

            $query->whereBetween('fecha_recepcion', $lapso);
        });
    }
}
