<?php

namespace App\Livewire\Configuracion\Area;

use App\Models\Configuracion\Area;
use Livewire\Attributes\On;
use Livewire\Component;

class AreaModificar extends Component
{
    public $name;
    public $actual;
    public $tipo=0;
    public $status;

    public function mount($elegido=null, $tipo=null){
        if($elegido){
            $this->actual=Area::find($elegido);
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
        'name' => 'required|unique:areas|max:100',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset('name');

    }

    // Crear Registro
    public function new(){
        // validate
        $this->validate();

        //Verificar que no exista el registro en la base de datos
        $existe=Area::Where('name', '=',strtolower($this->name))->count();

        if($existe>0){
            $this->dispatch('alerta', name:'Ya existe esta el área: '.$this->name);
        } else {

            //Crear registro
            Area::create([
                'name'          =>strtolower($this->name),
            ]);


            // Notificación
            $this->dispatch('alerta', name:'Se ha creado correctamente el área: '.$this->name);
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
        ]);

        // Notificación
        $this->dispatch('alerta', name:'Se ha modificado correctamente el área: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
    }

    public function render()
    {
        return view('livewire.configuracion.area.area-modificar');
    }
}
