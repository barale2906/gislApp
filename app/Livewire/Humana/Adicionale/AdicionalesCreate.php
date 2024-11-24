<?php

namespace App\Livewire\Humana\Adicionale;

use App\Models\Humana\Adicionale;
use Livewire\Attributes\On;
use Livewire\Component;

class AdicionalesCreate extends Component
{
    public $nombre;
    public $descripcion;
    public $valor_tra;
    public $tipo_tra;
    public $valor_emp;
    public $tipo_emp;
    public $actual;
    public $tipo=0;
    public $status;
    public $responsable;

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
        $this->valor_tra=$this->actual->valor_tra;
        $this->tipo_tra=$this->actual->tipo_tra;
        $this->tipo_emp=$this->actual->tipo_emp;
        $this->valor_emp=$this->actual->valor_emp;
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
        'valor_emp'=>'required|numeric|min:0',
        'tipo_emp'=>'required',
        'valor_tra'=>'required|numeric|min:0',
        'tipo_tra'=>'required',
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
            'valor_emp',
            'tipo_emp',
            'valor_tra',
            'tipo_tra',
            'status'
        );

    }

    // Crear Registro
    public function control(){
        // validate
        $this->validate();

        $this->reset('responsable');

        if($this->valor_tra==="0" || $this->valor_tra===0){
            $empleado=intval($this->valor_tra);
        }else{
            $empleado=floatval($this->valor_tra);
        }

        if($this->valor_emp==="0" || $this->valor_emp===0){
            $empresa=intval($this->valor_emp);
        }else{
            $empresa=floatval($this->valor_emp);
        }

        if($empresa===0 && $empleado===0){
            $this->dispatch('alerta', name:'Debe asignar un valor al empleado y/o la empresa.');
        }

        if($empresa===0 && $empleado>0){
            $this->responsable=0;
            $this->accion();
        }

        if($empresa>0 && $empleado===0){
            $this->responsable=1;
            $this->accion();
        }

        if($empresa>0 && $empleado>0){
            $this->responsable=2;
            $this->accion();
        }

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
            'valor_emp'       =>$this->valor_emp,
            'tipo_emp'        =>$this->tipo_emp,
            'valor_tra'       =>$this->valor_tra,
            'tipo_tra'        =>$this->tipo_tra,
            'responsable'     =>$this->responsable,
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
            'valor_emp'       =>$this->valor_emp,
            'tipo_emp'        =>$this->tipo_emp,
            'valor_tra'       =>$this->valor_tra,
            'tipo_tra'        =>$this->tipo_tra,
            'responsable'     =>$this->responsable,
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
