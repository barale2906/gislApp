<?php

namespace App\Livewire\Humana\Contrato;

use App\Models\Humana\Contrato;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class ContratosCreate extends Component
{
    public $nombre;
    public $descripcion;
    public $actual;
    public $tipo=0;
    public $status;

    public function mount($elegido=null, $tipo=null){
        if($elegido){
            $this->actual=Contrato::find($elegido);
            $this->tipo=$tipo;
            $this->valores();
        }
        if($tipo){
            $this->tipo=$tipo;
        }else{
            $this->tipo=0;
            $this->status=1;
        }
    }

    public function valores(){
        $this->nombre=$this->actual->nombre;
        $this->descripcion=$this->actual->descripcion;
        $this->status=$this->actual->status;
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
        'nombre'=>'required|unique:contratos',
        'descripcion'=>'required',
        'status'=>'required',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
            'nombre',
            'descripcion',
            'status'
        );

    }

    // Crear Registro
    public function new(){
        // validate
        $this->validate();

        //Crear registro
        Contrato::create([
            'nombre'          =>strtolower($this->nombre),
            'descripcion'     =>strtolower($this->descripcion),
            'status'          =>$this->status,
            'aprobado_id'     =>Auth::user()->id
        ]);


        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente el contrato: '.$this->nombre);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');

    }

    // Editar Registro
    public function edit(){

        // validate
        $this->validate();

        $this->actual->update([
            'nombre'          =>strtolower($this->nombre),
            'descripcion'     =>strtolower($this->descripcion),
            'status'          =>$this->status,
            'aprobado_id'     =>Auth::user()->id
        ]);

        // Notificación
        $this->dispatch('alerta', name:'Se ha actualizado correctamente el contrato: '.$this->nombre);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
    }

    public function render()
    {
        return view('livewire.humana.contrato.contratos-create');
    }
}
