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
    public $precio;

    public function mount($lista=null, $producto=null, $actual=null){
        if($lista){
            $this->lista=$lista;
        }
        if($producto){
            $this->producto=Producto::find($producto);
        }
        if($actual){
            $this->actual=ListaDetalle::find($actual);
            $this->valores();
        }
    }

    public function valores(){
        $this->precio=$this->actual->precio;
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'precio'       => 'required',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
            'precio'
        );

    }

    public function new(){

        // validate
        $this->validate();

        $esta=ListaDetalle::where('lista_id', $this->lista)
                            ->where('producto_id', $this->producto->id)
                            ->count();

        if($esta===0){
            ListaDetalle::create([
                'lista_id'      =>$this->lista,
                'producto_id'   =>$this->producto->id,
                'precio'        =>$this->precio
            ]);

            $this->dispatch('alerta', name:'Se anexo el producto: '.$this->producto->name.' a $ '.$this->precio);
            $this->resetFields();

            //refresh
            $this->dispatch('refresh');
            $this->dispatch('volviendo');
        }else{
            $this->dispatch('alerta', name:'El producto: '.$this->producto->name.' ya esta cargado a esta lista. ');
        }


    }

    public function edit(){
        // validate
        $this->validate();

        $this->actual->update([
            'precio'        =>$this->precio
        ]);

        $this->dispatch('alerta', name:'Se actualizo el producto: '.$this->actual->producto->name.' al $ '.$this->precio);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('volviendo');
    }

    public function render()
    {
        return view('livewire.facturacion.producto.producto-cargar');
    }
}
