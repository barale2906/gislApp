<?php

namespace App\Livewire\Configuracion\Ciudad;

use App\Models\Configuracion\Ciudad;
use Livewire\Attributes\On;
use Livewire\Component;

class CiudadModificar extends Component
{
    public $name;
    public $codigopostal;
    public $actual;
    public $tipo=0;
    public $status;

    public function mount($elegido=null, $tipo=null){
        if($elegido){
            $this->actual=Ciudad::find($elegido);
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
        $this->name=$this->actual->name;
        $this->codigopostal=$this->actual->codigopostal;

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
        'name' => 'required|unique:ciudads|max:100',
        'codigopostal'=>'required',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset('name', 'codigopostal');

    }

    // Crear Registro
    public function new(){
        // validate
        $this->validate();

        //Verificar que no exista el registro en la base de datos
        $existe=Ciudad::Where('name', '=',strtolower($this->name))->count();

        if($existe>0){
            $this->dispatch('alerta', name:'Ya existe esta ciudad: '.$this->name);
        } else {

            //Crear registro
            Ciudad::create([
                'name'          =>strtolower($this->name),
                'codigopostal'  =>strtolower($this->codigopostal),
            ]);


            // Notificación
            $this->dispatch('alerta', name:'Se ha creado correctamente ciudad: '.$this->name);
            $this->resetFields();

            //refresh
            $this->dispatch('refresh');
            $this->dispatch('cancelando');
        }
    }

    // Modificr
    public function edit(){

        // validate
        $this->validate();

        $this->actual->update([
            'name'          =>strtolower($this->name),
            'codigopostal'  =>strtolower($this->codigopostal),
        ]);

        // Notificación
        $this->dispatch('alerta', name:'Se ha modificado correctamente la ciudad: '.strtolower($this->name));
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
    }


    public function render()
    {
        return view('livewire.configuracion.ciudad.ciudad-modificar');
    }
}
