<?php

namespace App\Livewire\Diligencia\Gestion;

use Livewire\Component;

class Mensajero extends Component
{
    public $is_mias=true;
    public $is_todas=false;
    public $is_editar=false;

    public function tipo($id){
        switch ($id) {
            case '1':
                $this->clear();
                break;

            case '2':
                $this->is_mias=!$this->is_mias;
                $this->is_todas=!$this->is_todas;
                break;
        }
    }

    public function clear(){
        $this->reset(
            'is_mias',
            'is_todas',
            'is_editar'
        );
    }
    public function render()
    {
        return view('livewire.diligencia.gestion.mensajero');
    }
}
