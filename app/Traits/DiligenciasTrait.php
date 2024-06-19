<?php

namespace App\Traits;

use App\Models\Diligencias\Diligencia;
use Illuminate\Support\Facades\Auth;

trait DiligenciasTrait
{
    public $nulo;

    public function generales(){

        switch ($this->is_lista) {
            case 1:
                return Diligencia::where('status', '<=', 3)
                                    ->where('empresa_id', Auth::user()->empresa_id)
                                    ->mias(Auth::user()->id)
                                    ->buscar($this->busqueda)
                                    ->creado($this->filtrocrea)
                                    ->entregado($this->filtroentrega)
                                    ->orderBy($this->ordena, $this->ordenado)
                                    ->paginate($this->pages);
                break;
            case 2:
                return Diligencia::where('status', '<=', 3)
                                    ->where('empresa_id', Auth::user()->empresa_id)
                                    ->area($this->ubica)
                                    ->buscar($this->busqueda)
                                    ->creado($this->filtrocrea)
                                    ->entregado($this->filtroentrega)
                                    ->orderBy($this->ordena, $this->ordenado)
                                    ->paginate($this->pages);
                break;
            case 3:
                return Diligencia::where('status', '<=', 3)
                                    ->where('empresa_id', Auth::user()->empresa_id)
                                    ->miallega(Auth::user()->id)
                                    ->buscar($this->busqueda)
                                    ->creado($this->filtrocrea)
                                    ->entregado($this->filtroentrega)
                                    ->orderBy($this->ordena, $this->ordenado)
                                    ->paginate($this->pages);
                break;
            case 4:
                return Diligencia::where('status', '<=', 3)
                                    ->where('empresa_id', Auth::user()->empresa_id)
                                    ->areallega($this->ubica)
                                    ->buscar($this->busqueda)
                                    ->creado($this->filtrocrea)
                                    ->entregado($this->filtroentrega)
                                    ->orderBy($this->ordena, $this->ordenado)
                                    ->paginate($this->pages);
                break;
            case 5:
                return Diligencia::where('status', '>=', 1)
                                    ->where('empresa_id', Auth::user()->empresa_id)
                                    ->mias(Auth::user()->id)
                                    ->buscar($this->busqueda)
                                    ->creado($this->filtrocrea)
                                    ->entregado($this->filtroentrega)
                                    ->orderBy($this->ordena, $this->ordenado)
                                    ->paginate($this->pages);
                break;
            case 6:
                return Diligencia::where('status', '>=', 1)
                                    ->where('empresa_id', Auth::user()->empresa_id)
                                    ->area($this->ubica)
                                    ->buscar($this->busqueda)
                                    ->creado($this->filtrocrea)
                                    ->entregado($this->filtroentrega)
                                    ->orderBy($this->ordena, $this->ordenado)
                                    ->paginate($this->pages);
                break;
            case 7:
                return Diligencia::where('status', '>=', 1)
                                    ->where('empresa_id', Auth::user()->empresa_id)
                                    ->miallega(Auth::user()->id)
                                    ->buscar($this->busqueda)
                                    ->creado($this->filtrocrea)
                                    ->entregado($this->filtroentrega)
                                    ->orderBy($this->ordena, $this->ordenado)
                                    ->paginate($this->pages);
                break;
            case 8:
                return Diligencia::where('status', '>=', 1)
                                    ->where('empresa_id', Auth::user()->empresa_id)
                                    ->areallega($this->ubica)
                                    ->buscar($this->busqueda)
                                    ->creado($this->filtrocrea)
                                    ->entregado($this->filtroentrega)
                                    ->orderBy($this->ordena, $this->ordenado)
                                    ->paginate($this->pages);
                break;
        }

    }

    public function gestionar($status, $nulo=null){
        if($nulo){
            $this->nulo=$nulo;
        }else{
            $this->nulo='id';
        }
        return Diligencia::whereBetween('status', $status)
                            ->buscar($this->busqueda)
                            ->creado($this->filtrocrea)
                            ->where('status_factura', 1)
                            ->where('numero_fac', null)
                            ->where('seguimiento', true)
                            ->whereNotNull($this->nulo)
                            ->orderBy($this->ordena, $this->ordenado)
                            ->paginate($this->pages);

    }
}
