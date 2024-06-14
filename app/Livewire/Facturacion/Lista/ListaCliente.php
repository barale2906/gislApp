<?php

namespace App\Livewire\Facturacion\Lista;

use App\Models\Facturacion\Empresa;
use App\Models\Facturacion\Lista;
use App\Models\Facturacion\ListaEmpresa;
use Livewire\Component;

class ListaCliente extends Component
{
    public $lista;
    public $empresa;
    public $seleccionado;
    public $actual;
    public $encontradas=0;
    public $descuento;
    public $tipop;
    public $is_procesa=false;

    public function mount($lista,$empresa,$descuento=null){

        $this->lista=$lista;
        $this->empresa=$empresa;
        if($descuento){

            if(intval($descuento)>100){
                $this->dispatch('alerta', name:'El descuento no puede ser mayor al 100%');
                $this->dispatch('remitiendo');
            }else{
                $this->descuento=$descuento;
                $this->existe();
            }

        }else{
            $this->descuento=0;
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
                                ->whereNot('lista_id', intval($this->lista))
                                ->where('status', '>', 0)
                                ->get();

        $this->actual=Lista::find($this->lista);


        if ($restringe) {

            foreach ($restringe as $value) {
                $crt=Lista::find($value->lista_id);

                if($this->actual->inicia>=$crt->inicia && $this->actual->inicia<=$crt->finaliza){
                    $this->encontradas=$this->encontradas+1;
                }

                if($this->actual->finaliza>=$crt->inicia && $this->actual->finaliza<=$crt->finaliza){
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
                                        ->select('name','id')
                                        ->first();

            $this->cliente();
        }

    }

    public function cliente(){

        ListaEmpresa::create([
            'empresa_id'    => $this->seleccionado->id,
            'lista_id'      => $this->lista,
            'empresa'       => $this->seleccionado->name,
            'descuento'     => $this->descuento,
            'status'        => $this->actual->status
        ]);

        $this->dispatch('alerta', name:'Se asigno correctamente la empresa a esta lista');
        $this->dispatch('remitiendo');
    }

    /* public function render()
    {
        return view('livewire.facturacion.lista.lista-cliente');
    } */
}
