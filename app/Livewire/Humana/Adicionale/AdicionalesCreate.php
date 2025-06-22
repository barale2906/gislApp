<?php

namespace App\Livewire\Humana\Adicionale;

use App\Models\Humana\Adicionale;
use Livewire\Attributes\On;
use Livewire\Component;

class AdicionalesCreate extends Component
{
    public $nombre;
    public $descripcion;
    public $aplica;
    public $valor;
    public $form_calculo;
    public $actual;
    public $tipo=0;
    public $status;

    public function mount($elegido=null, $tipo=null){
        if($elegido){
            $this->actual=Adicionale::find($elegido);
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
        $this->aplica=$this->actual->aplica;
        $this->form_calculo=$this->actual->form_calculo;
        $this->valor=$this->actual->valor;
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
        'aplica'=>'required',
        'valor'=>'required|numeric',
        'form_calculo'=>'required',
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
            'aplica',
            'valor',
            'form_calculo',
            'status'
        );
    }

    // Crear Registro
    public function control(){
        // validate
        $this->validate();
        $this->accion();
    }

    public function accion(){
        switch ($this->tipo) {
            case 0:
                $this->crearadic();
                break;

            case 1:
                $this->edit();
                break;
        }
    }

    public function crearadic(){
        //Crear registro
        Adicionale::create([
            'nombre'          =>strtolower($this->nombre),
            'descripcion'     =>strtolower($this->descripcion),
            'aplica'          =>$this->aplica,
            'valor'           =>$this->valor,
            'form_calculo'    =>$this->form_calculo,
            'status'          =>$this->status,
        ]);


        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente el adicional: '.$this->nombre);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
    }

    // Editar Registro
    public function edit(){

        $this->actual->update([
            'nombre'          =>strtolower($this->nombre),
            'descripcion'     =>strtolower($this->descripcion),
            'aplica'          =>$this->aplica,
            'valor'           =>$this->valor,
            'form_calculo'    =>$this->form_calculo,
            'status'          =>$this->status,
        ]);

        // Notificación
        $this->dispatch('alerta', name:'Se ha actualizado correctamente el adicional: '.$this->nombre);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
    }

    public function render()
    {
        return view('livewire.humana.adicionale.adicionales-create');
    }
}
