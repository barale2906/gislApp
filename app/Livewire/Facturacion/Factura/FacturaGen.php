<?php

namespace App\Livewire\Facturacion\Factura;

use Livewire\Component;
use Livewire\WithPagination;

class FacturaGen extends Component
{
    use WithPagination;

    public $is_diligencias=false;
    public $is_items=false;

    public function tipo($id){
        $this->limpiar();
        switch ($id) {
            case '1':
                $this->is_items=!$this->is_items;
                break;

            case '2':
                $this->is_diligencias=!$this->is_diligencias;
                break;
        }
    }

    public function limpiar(){
        $this->reset(
                'is_diligencias',
                'is_items'
            );
    }
    public function render()
    {
        return view('livewire.facturacion.factura.factura-gen');
    }
}
