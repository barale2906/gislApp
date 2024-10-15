<?php

namespace App\Livewire\Diligencia\Gestion;

use App\Models\Diligencias\Diligencia;
use Livewire\Component;

class Consulta extends Component
{
    public $codigo;
    public $intentos=0;
    public $uno;
    public $dos;
    public $total;
    public $is_referencia=false;
    public $diligencia;

    public function mount(){
        $this->uno=rand(0,10);
        $this->dos=rand(0,10);
    }

    public function verifica(){
        if($this->intentos<3){
            if(intval($this->total)===intval($this->uno)+intval($this->dos)){
                $this->seguimiento();
            }else{
                $this->intentos=$this->intentos+1;
                $this->dispatch('alerta', name:'Verifique la operación. Utilizó: '.$this->intentos.' de 3 intentos');
                $this->mount();
                $this->reset('total');
            }
        }else{
            $this->dispatch('alerta', name:'Utilizó: '.$this->intentos.' de 3 intentos. ¡Intente más tarde!');
        }

    }

    public function seguimiento(){
        $this->reset('uno', 'dos', 'total');
        $this->mount();
        $this->is_referencia=true;
        $this->diligencia=Diligencia::where('identificador', $this->codigo)
                                    ->where('status_factura', 1)
                                    ->first();
    }

    public function render()
    {
        return view('livewire.diligencia.gestion.consulta');
    }
}
