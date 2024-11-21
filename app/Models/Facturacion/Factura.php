<?php

namespace App\Models\Facturacion;

use App\Models\Financiera\Cartera;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Factura extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Relación uno a muchos.
     * Registro de Cartera
     */
    public function cartera() : HasOne
    {
        return $this->hasOne(Cartera::class);
    }

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

    /**
     * Relación uno a muchos inversa.
     * Usuario creador de la factura
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    //Buscar
    public function scopeBuscar($query, $item){
        $query->when($item ?? null, function($query, $item){
                    $query->where('cliente', 'like', "%".$item."%")
                        ->orwhere('numero', 'like', "%".$item."%")
                        ->orWherehas('empresa', function($query) use($item) {
                            $query->where('empresas.nit', 'like', "%".$item."%");
                        })
                        ->orWherehas('lista', function($query) use($item) {
                            $query->where('listas.name', 'like', "%".$item."%");
                        });
                });

    }
    // Creado
    public function scopeCreado($query, $lapso){
        $query->when($lapso ?? null, function($query, $lapso){
            $fecha1=Carbon::parse($lapso[0]);
            $fecha2=Carbon::parse($lapso[1]);
            $fecha2->addSeconds(86399);
            $query->whereBetween('created_at', [$fecha1 , $fecha2]);
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
