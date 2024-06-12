<?php

namespace App\Livewire\Facturacion\Empresa;

use App\Models\Facturacion\Lista;
use Livewire\Component;

class EmpresaPrecio extends Component
{
    public $lista;
    public $empresa;
    public $is_cargar=false;

    public function mount($lista,$empresa){
        $this->lista=Lista::find($lista);
        $this->empresa=$empresa;
        $this->vigencias();
    }

    public function vigencias(){
        $restringe=Lista::where('finaliza','>=',$this->lista->inicia)
                            ->orwhere('inicia','<=',$this->lista->finaliza)
                            ->select('id')
                            ->get();
    }

    public function render()
    {
        return view('livewire.facturacion.empresa.empresa-precio');
    }
}
