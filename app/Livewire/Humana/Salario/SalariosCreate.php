<?php

namespace App\Livewire\Humana\Salario;

use App\Models\Humana\Contrato;
use App\Models\Humana\Salario;
use App\Traits\StatusTrait;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class SalariosCreate extends Component
{
    use StatusTrait;

    public $contrato_id;
    public $basico;
    public $subsidio_transporte;
    public $rodamiento;
    public $salud;
    public $pension;
    public $arl;
    public $cesantias;
    public $vacaciones;
    public $dotaciones;
    public $anio;
    public $observaciones;
    public $actual;
    public $tipo;
    public $status;

    public function mount($elegido=null, $tipo=null){
        if($elegido){
            $this->actual=Salario::find($elegido);
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
        $this->contrato_id=$this->actual->contrato_id;
        $this->basico=$this->actual->basico;
        $this->subsidio_transporte=$this->actual->subsidio_transporte;
        $this->rodamiento=$this->actual->rodamiento;
        $this->salud=$this->actual->salud;
        $this->pension=$this->actual->pension;
        $this->arl=$this->actual->arl;
        $this->cesantias=$this->actual->cesantias;
        $this->vacaciones=$this->actual->vacaciones;
        $this->dotaciones=$this->actual->dotaciones;
        $this->anio=$this->actual->anio;
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

        $this->dispatch('alerta', name:'Se cambio el estado');
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
    }

    /**
     * Reglas de validación
     */
    protected $rules = [

        'contrato_id'=>'required|integer',
        'basico'=>'required|numeric|min: 0',
        'subsidio_transporte'=>'required|numeric|min: 0',
        'rodamiento'=>'required|numeric|min: 0',
        'salud'=>'required|numeric|min: 0',
        'pension'=>'required|numeric|min: 0',
        'arl'=>'required|numeric|min: 0',
        'cesantias'=>'required|numeric|min: 0',
        'vacaciones'=>'required|numeric|min: 0',
        'dotaciones'=>'required|numeric|min: 0',
        'anio'=>'required|digits:4|integer|min:1901|max:2155',
        'observaciones'=>'required',

    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
                'contrato_id',
                'basico',
                'subsidio_transporte',
                'rodamiento',
                'salud',
                'pension',
                'arl',
                'cesantias',
                'vacaciones',
                'dotaciones',
                'anio',
                'observaciones',
                'actual',
                'tipo',
                'status',
        );

    }

    // Crear Registro
    public function new(){
        // validate
        $this->validate();

        $obs=now().": ".Auth::user()->name." creo el salario, ".strtolower($this->observaciones);
        //Crear registro
        Salario::create([
                'contrato_id' => $this->contrato_id,
                'basico' => $this->basico,
                'subsidio_transporte' => $this->subsidio_transporte,
                'rodamiento' => $this->rodamiento,
                'salud' => $this->salud,
                'pension' => $this->pension,
                'arl' => $this->arl,
                'cesantias' => $this->cesantias,
                'vacaciones' => $this->vacaciones,
                'dotaciones' => $this->dotaciones,
                'anio' => $this->anio,
                'observaciones' => $obs,
                'status' => $this->status,
        ]);


        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente el salario.');
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');

    }

    // Editar Registro
    public function edit(){

        // validate
        $this->validate();

        $obs=now().": ".Auth::user()->name." Edito el salario: ".strtolower($this->observaciones)." ----- ".$this->actual->observaciones;

        $this->actual->update([
            'contrato_id' => $this->contrato_id,
            'basico' => $this->basico,
            'subsidio_transporte' => $this->subsidio_transporte,
            'rodamiento' => $this->rodamiento,
            'salud' => $this->salud,
            'pension' => $this->pension,
            'arl' => $this->arl,
            'cesantias' => $this->cesantias,
            'vacaciones' => $this->vacaciones,
            'dotaciones' => $this->dotaciones,
            'anio' => $this->anio,
            'observaciones' => $obs,
            'status' => $this->status,
        ]);

        // Notificación
        $this->dispatch('alerta', name:'Se ha actualizado correctamente el salario');
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
    }




    private function contratos(){
        return Contrato::orderBy('status','DESC')
                        ->orderBy('nombre', 'ASC')
                        ->get();
    }


    public function render()
    {
        return view('livewire.humana.salario.salarios-create',[
            'contratos' => $this->contratos()
        ]);
    }
}
