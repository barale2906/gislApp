<?php

namespace App\Models\Financiera;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Buscar
    public function scopeBuscar($query, $item){
        $query->when($item ?? null, function($query, $item){
                    $query->where('nombre', 'like', "%".$item."%")
                        ->orwhere('banco', 'like', "%".$item."%")
                        ->orwhere('numero', 'like', "%".$item."%")
                        ->orwhere('tipo', 'like', "%".$item."%");
                });

    }
}
