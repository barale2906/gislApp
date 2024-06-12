<?php

namespace App\Livewire\Facturacion\Producto;

use App\Models\Facturacion\ListaDetalle;
use App\Models\Facturacion\Producto;
use Livewire\Component;

class ProductoCargar extends Component
{
    public $producto;
    public $lista;
    public $actual;

    public function mount($lista=null, $producto=null, $actual=null){
        if($lista){
            $this->lista=$lista;
        }
        if($producto){
            $this->producto=Producto::find($producto);
        }
        if($actual){
            $this->actual=ListaDetalle::find($actual);
        }
    }
    public function render()
    {
        return view('livewire.facturacion.producto.producto-cargar');
    }
}
