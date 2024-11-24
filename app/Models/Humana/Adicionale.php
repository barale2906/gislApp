<?php

namespace App\Models\Humana;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adicionale extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Buscar
    public function scopeBuscar($query, $item){
        $query->when($item ?? null, function($query, $item){
                    $query->where('nombre', 'like', "%".$item."%")
                        ->orwhere('descripcion', 'like', "%".$item."%");
                });

    }
}