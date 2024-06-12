<?php

namespace App\Livewire\Facturacion\Empresa;

use App\Models\Facturacion\Empresa;
use App\Models\Facturacion\Lista;
use App\Models\Facturacion\ListaEmpresa;
use Livewire\Component;

class EmpresaPrecio extends Component
{
    public $lista;
    public $empresa;
    public $seleccionado;
    public $actual;
    public $encontradas=0;
    public $descuento;
    public $tipop;
    public $is_procesa=false;

    public function mount($lista,$empresa,$tipop=null){
        $this->lista=$lista;
        $this->empresa=$empresa;
        if($tipop){
            $this->tipop=$tipop;

        }else{
            $this->tipop=0;
            $this->existe();
        }

    }

    public function existe(){
        $esta=ListaEmpresa::where('lista_id',intval($this->lista))
                            ->where('empresa_id',intval($this->empresa))
                            ->count();

        if($esta>0){
            $this->dispatch('alerta', name:'La empresa seleccionada ya esta cargada a la lista. ');
            $this->dispatch('remitiendo');
        }else{
            $this->vigencias();
        }

    }

    public function vigencias(){

        $restringe=ListaEmpresa::where('empresa_id',intval($this->empresa))
                                ->where('lista_id', '!==', intval($this->lista))
                                ->where('status', '>', 0)
                                ->get();

        $this->actual=Lista::find($this->lista);

        if ($restringe) {

            foreach ($restringe as $value) {

                if($this->actual->inicia>=$value->listas->inicia && $this->actual->inicia<=$value->listas->finaliza){
                    $this->encontradas=$this->encontradas+1;
                }

                if($this->actual->finaliza>=$value->listas->inicia && $this->actual->finaliza<=$value->listas->finaliza){
                    $this->encontradas=$this->encontradas+1;
                }
            }

        }
        $this->aprueba();
    }

    public function aprueba(){

        if($this->encontradas>0){
            $this->dispatch('alerta', name:'La empresa ya tiene asignada una lista con esta vigencia.');
            $this->dispatch('remitiendo');
        }else{

            $this->seleccionado=Empresa::where('id', intval($this->empresa))
                                        ->select('name')
                                        ->first();

            $this->is_procesa=!$this->is_procesa;
        }

    }

    public function render()
    {
        return view('livewire.facturacion.empresa.empresa-precio');
    }
}
