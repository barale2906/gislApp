<?php

namespace App\Imports;

use App\Models\Configuracion\Ubica;
use App\Models\Diligencias\Diligencia;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;

class DiligenciasImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $ubica=Ubica::where('user_id', Auth::user()->id)
                        ->where('status', true)
                        ->first();

        return new Diligencia([
            'ubica_id'          =>$ubica->id,//$row[0],
            'empresa_id'        =>$ubica->empresa_id,//$row[1],
            'name_dest'         =>$row[0],
            'direccion_dest'    =>$row[1],
            'ciudad_id'         =>$row[2],
            'descripcion'       =>strtolower($row[3]),
            'detalle'           =>strtolower($row[4]),
            'seguimiento'       =>1,
            'tipo'              =>2
        ]);

    }
}
