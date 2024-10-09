<?php

namespace App\Livewire\Financiera\Concepto;

use App\Models\Financiera\Concepto;
use Livewire\Attributes\On;
use Livewire\Component;

class ConceptosCreate extends Component
{
    public $concepto;
    public $name;
    public $cuenta;
    public $tip;
    public $accion=1;
    public $actual;
    public $tipo=0;
    public $status;
    public $is_accion=false;

    public function mount($elegido=null, $tipo=null){
        if($elegido){
            $this->actual=Concepto::find($elegido);
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
        $this->name=$this->actual->concepto;

        if($this->actual->status===1){
            $this->status=true;
        }else{
            $this->status=false;
        }
    }

    public function updatedTip(){

        $this->reset('is_accion','accion');
        $tip=intval($this->tip);

        if($tip===1){
            $this->is_accion=true;
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
        'concepto'=>'required|unique:conceptos',
        'tipo'=>'required',
        'accion'=>'required',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
            'concepto',
            'cuenta',
            'tip',
            'accion'
        );

    }

    // Crear Registro
    public function new(){
        // validate
        $this->validate();

        //Crear registro
        Concepto::create([
            'concepto'  =>strtolower($this->concepto),
            'cuenta'    =>strtolower($this->cuenta),
            'tipo'      =>$this->tip,
            'accion'    =>$this->accion
        ]);


        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente el concepto: '.$this->concepto);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');

    }

    public function render()
    {
        return view('livewire.financiera.concepto.conceptos-create');
    }
}
