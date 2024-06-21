<?php

namespace App\Livewire\Financiera\Banco;

use App\Models\Financiera\Banco;
use Livewire\Attributes\On;
use Livewire\Component;

class BancosCreate extends Component
{
    public $nombre;
    public $name;
    public $banco;
    public $numero;
    public $tip;
    public $actual;
    public $tipo=0;
    public $status;

    public function mount($elegido=null, $tipo=null){
        if($elegido){
            $this->actual=Banco::find($elegido);
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
        $this->name=$this->actual->nombre;

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
        'nombre'=>'required|unique:bancos',
        'banco'=>'required',
        'numero'=>'required|unique:bancos',
        'tipo'=>'required',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
            'nombre',
            'banco',
            'numero',
            'tip',
        );

    }

    // Crear Registro
    public function new(){
        // validate
        $this->validate();

        //Crear registro
        Banco::create([
            'nombre'    =>strtolower($this->nombre),
            'banco'     =>strtolower($this->banco),
            'numero'    =>strtolower($this->numero),
            'tipo'      =>strtolower($this->tip),
        ]);


        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente el banco: '.$this->nombre);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');

    }

    public function render()
    {
        return view('livewire.financiera.banco.bancos-create');
    }
}
