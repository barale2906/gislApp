<?php

namespace App\Livewire\Facturacion\Producto;

use App\Models\Facturacion\Producto;
use Livewire\Attributes\On;
use Livewire\Component;

class ProductoModificar extends Component
{
    public $name;
    public $descripcion;
    public $clase;
    public $status;

    public $actual;
    public $tipo;

    public function mount($elegido=null, $tipo=null){
        if($elegido){
            $this->actual=Producto::find($elegido);
            $this->tipo=$tipo;
            $this->valores();
        }
        if($tipo){
            $this->tipo=$tipo;
        }else{
            $this->tipo=0;
        }
    }

    public function valores(){
        $this->name=                $this->actual->name;
        $this->descripcion=         $this->actual->descripcion;
        $this->clase=               $this->tipo;

        if($this->actual->status===1){
            $this->status=true;
        }else{
            $this->status=false;
        }
    }

    //Inactivar Registro
    //Activar evento
    #[On('inactivando')]
    public function inactivar(){

        //Actualizar registros
        $this->actual->update([
                            'status'=>!$this->status
                        ]);

        $this->dispatch('alerta', name:'Se cambio el estado de: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'name'              => 'required|unique:productos',
        'descripcion'       => 'required',
        'clase'             => 'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
            'name',
            'descripcion'
        );

    }

    // Crear Registro
    public function new(){
        // validate
        $this->validate();

        //Crear
        Producto::create([
            'name'              => strtolower($this->name),
            'descripcion'       => strtolower($this->descripcion),
            'tipo'              => $this->clase
        ]);

        $this->dispatch('alerta', name:'Se ha creado correctamente el producto: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
    }

    public function edit(){

        if($this->name){
            $this->actual->update([
                'name'              => strtolower($this->name),
                'descripcion'       => strtolower($this->descripcion),
                'tipo'              => $this->clase
            ]);

            $this->dispatch('alerta', name:'Se ha modificado correctamente el producto: '.$this->name);
            $this->resetFields();

            //refresh
            $this->dispatch('refresh');
            $this->dispatch('cancelando');
        }else{
            $this->dispatch('alerta', name:'Los campos son obligatorios');
        }
    }

    public function render()
    {
        return view('livewire.facturacion.producto.producto-modificar');
    }
}
