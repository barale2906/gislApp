<?php

namespace App\Livewire\Humana\Contrato;

use App\Models\Humana\Contrato;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class ContratosCreate extends Component
{
    public $nombre;
    public $descripcion;
    public $observaciones;
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
    /* protected $rules = [
        'nombre'=>'required|unique:contratos',
        'descripcion'=>'required',
        'status'=>'required',
    ]; */

    public function rules()
    {
        $rules = [
            'descripcion'       => 'required',
            'observaciones'     => 'required',
            'status'            => 'required',
        ];

        // Regla condicional para el nombre
        if($this->actual){
            $rules['nombre']=['required', Rule::unique('contratos')->ignore($this->actual->id)];
        }else{
            $rules['nombre']=['required', 'unique:contratos'];
        }

        return $rules;
    }

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
            'nombre',
            'descripcion',
            'observaciones',
            'status'
        );

    }

    // Crear Registro
    public function new(){
        // validate
        $this->validate();

        $obs=now().": ".Auth::user()->name." creo el contrato, ".strtolower($this->observaciones);
        //Crear registro
        Contrato::create([
            'nombre'          =>strtolower($this->nombre),
            'descripcion'     =>strtolower($this->descripcion),
            'observaciones'   =>$obs,
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

        if($this->descripcion){
            $this->descripcion=$this->descripcion." ----- ".$this->actual->descripcion;
        }else{
            $this->descripcion=$this->descripcion;
        }


        // validate
        $this->validate();

        $obs=now().": ".Auth::user()->name." Edito el contrato: ".strtolower($this->observaciones)." ----- ".$this->actual->observaciones;

        $this->actual->update([
            'nombre'          =>strtolower($this->nombre),
            'descripcion'     =>strtolower($this->descripcion),
            'observaciones'   =>$obs,
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
