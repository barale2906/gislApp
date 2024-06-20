<?php

namespace App\Traits;

use App\Models\Configuracion\Ubica;
use App\Models\User;
use Spatie\Permission\Models\Role;

trait UsersTrait
{
    public $usuconsulta;
    public $ubicacion;

    public function rolusuarios($rol){

        $usuario=Role::where('name',$rol)
                    ->where('status', true)
                    ->select('id')
                    ->first();

        return User::where('rol_id', $usuario->id)
                    ->orderBy('name', 'ASC')
                    ->get();

    }
    public function usuario($id){
        $this->usuconsulta=User::find($id);
        $this->ubicacion=Ubica::where('user_id', $id)
                                ->where('status', true)
                                ->first();
    }
}
