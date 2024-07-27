<?php

namespace App\Imports;

use App\Models\Diligencias\Diligencia;
use Exception;
use Illuminate\Support\Facades\Log;
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
        return new Diligencia([
            'ubica_id'          =>$row[0],
            'empresa_id'        =>$row[1],
            'name_dest'         =>$row[2],
            'direccion_dest'    =>$row[3],
            'ciudad_id'         =>$row[4],
            'descripcion'       =>strtolower($row[5]),
            'detalle'           =>strtolower($row[6]),
            'seguimiento'       =>1,
            'tipo'              =>2
        ]);

    }
}
