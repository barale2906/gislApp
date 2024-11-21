<?php

namespace App\Traits;

use App\Models\Diligencias\Diligencia;
use App\Models\Diligencias\Dilimensajero;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait DiligenciasTrait
{
    public $nulo;
    public $seleccionados;
    public $mensajero;

    public function generales(){

        switch ($this->is_lista) {
            case 1:
                return Diligencia::where('status', '<=', 3)
                                    ->where('empresa_id', Auth::user()->empresa_id)
                                    ->mias(Auth::user()->id)
                                    ->buscar($this->busqueda)
                                    ->entrega($this->filtrocrea)
                                    ->entregado($this->filtroentrega)
                                    ->orderBy($this->ordena, $this->ordenado)
                                    ->paginate($this->pages);
                break;
            case 2:
                return Diligencia::where('status', '<=', 3)
                                    ->where('empresa_id', Auth::user()->empresa_id)
                                    ->area($this->ubica)
                                    ->buscar($this->busqueda)
                                    ->entrega($this->filtrocrea)
                                    ->entregado($this->filtroentrega)
                                    ->orderBy($this->ordena, $this->ordenado)
                                    ->paginate($this->pages);
                break;
            case 3:
                return Diligencia::where('status', '<=', 3)
                                    ->where('empresa_id', Auth::user()->empresa_id)
                                    ->miallega(Auth::user()->id)
                                    ->buscar($this->busqueda)
                                    ->entrega($this->filtrocrea)
                                    ->entregado($this->filtroentrega)
                                    ->orderBy($this->ordena, $this->ordenado)
                                    ->paginate($this->pages);
                break;
            case 4:
                return Diligencia::where('status', '<=', 3)
                                    ->where('empresa_id', Auth::user()->empresa_id)
                                    ->areallega($this->ubica)
                                    ->buscar($this->busqueda)
                                    ->entrega($this->filtrocrea)
                                    ->entregado($this->filtroentrega)
                                    ->orderBy($this->ordena, $this->ordenado)
                                    ->paginate($this->pages);
                break;
            case 5:
                return Diligencia::where('status', '>=', 1)
                                    ->where('empresa_id', Auth::user()->empresa_id)
                                    ->mias(Auth::user()->id)
                                    ->buscar($this->busqueda)
                                    ->entrega($this->filtrocrea)
                                    ->entregado($this->filtroentrega)
                                    ->orderBy($this->ordena, $this->ordenado)
                                    ->paginate($this->pages);
                break;
            case 6:
                return Diligencia::where('status', '>=', 1)
                                    ->where('empresa_id', Auth::user()->empresa_id)
                                    ->area($this->ubica)
                                    ->buscar($this->busqueda)
                                    ->entrega($this->filtrocrea)
                                    ->entregado($this->filtroentrega)
                                    ->orderBy($this->ordena, $this->ordenado)
                                    ->paginate($this->pages);
                break;
            case 7:
                return Diligencia::where('status', '>=', 1)
                                    ->where('empresa_id', Auth::user()->empresa_id)
                                    ->miallega(Auth::user()->id)
                                    ->buscar($this->busqueda)
                                    ->entrega($this->filtrocrea)
                                    ->entregado($this->filtroentrega)
                                    ->orderBy($this->ordena, $this->ordenado)
                                    ->paginate($this->pages);
                break;
            case 8:
                return Diligencia::where('status', '>=', 1)
                                    ->where('empresa_id', Auth::user()->empresa_id)
                                    ->areallega($this->ubica)
                                    ->buscar($this->busqueda)
                                    ->entrega($this->filtrocrea)
                                    ->entregado($this->filtroentrega)
                                    ->orderBy($this->ordena, $this->ordenado)
                                    ->paginate($this->pages);
                break;
        }

    }

    public function gestionar($status, $nulo=null){
        if($nulo){
            return Diligencia::whereBetween('status', $status)
                            ->buscar($this->busqueda)
                            ->entrega($this->filtrocrea)
                            ->ciudad($this->ciudad)
                            ->mensajero($this->mensafiltro)
                            ->where('seguimiento', true)
                            ->orderBy($this->ordena, $this->ordenado)
                            ->paginate($this->pages);
        }else{
            return Diligencia::whereBetween('status', $status)
                            ->buscar($this->busqueda)
                            ->entrega($this->filtrocrea)
                            ->ciudad($this->ciudad)
                            ->mensajero($this->mensafiltro)
                            ->where('status_factura', 1)
                            ->where('numero_fac', null)
                            ->where('seguimiento', true)
                            ->orderBy($this->ordena, $this->ordenado)
                            ->paginate($this->pages);
        }


    }

    public function asignados(){
        $ids=array();

        $mensajeros=Dilimensajero::whereIn('status', [1,2])
                                    ->select('user_id')
                                    ->groupBy('user_id')
                                    ->get();

        foreach ($mensajeros as $value) {
            if(in_array($value->user_id, $ids)){

            }else{
                array_push($ids, $value->user_id);
            }
        }

        $this->seleccionados = User::whereIn('id',$ids)
                                    ->select('id','name')
                                    ->orderBy('name', 'ASC')
                                    ->get();
    }

    public function elegirmensajero($id){
        $this->mensajero=$id;
    }

    public function historial(){
        if ($this->mensajero) {
            return Dilimensajero::where('user_id',$this->mensajero)
                                ->buscar($this->busqueda)
                                ->entrega($this->filtrocrea)
                                ->whereBetween('status', [1,3])
                                ->orderBy($this->ordena, $this->ordenado)
                                ->paginate($this->pages);
        }

    }
}
