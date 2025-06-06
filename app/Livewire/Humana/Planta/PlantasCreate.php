<?php

namespace App\Livewire\Humana\Planta;

use App\Models\Humana\Contrato;
use App\Models\Humana\Planta;
use App\Models\Humana\Salario;
use App\Models\User;
use App\Traits\StatusTrait;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class PlantasCreate extends Component
{
    use StatusTrait;

    public $user_id;
    public $contrato_id;
    public $salario_id;
    public $salarios;
    public $sal;
    public $cont;
    public $nombre;
    public $anio;
    public $inicia;
    public $finaliza;
    public $observaciones;
    public $status=0;
    public $actual;
    public $tipo=0;


    public function mount($elegido=null, $tipo=null){
        if($elegido){
            $this->actual=Planta::find($elegido);
            $this->tipo=$tipo;
            $this->valores();
        }
        if($tipo){
            $this->tipo=$tipo;
        }else{
            $this->tipo=0;
        }
    }

    public function updatedContratoId(){
        $this->salarios = Salario::where('contrato_id', $this->contrato_id)
                                    ->where('status', 2)
                                    ->orderBy('anio', 'DESC')
                                    ->get();
    }


    public function valores(){

            $this->user_id       = $this->actual->user_id;
            $this->nombre        = $this->actual->nombre;
            $this->anio          = $this->actual->anio;
            $this->inicia        = $this->actual->inicia;
            $this->finaliza      = $this->actual->finaliza;
            $this->status        = $this->actual->status;

            $this->salarioContrato();
    }

    public function salarioContrato(){
        $this->sal=Salario::find($this->actual->salario_id);

        $cont=Contrato::find($this->actual->contrato_id);
        $this->cont=$cont->nombre;
    }

    //Inactivar Registro
    //Activar evento
    #[On('inactivando')]
    public function inactivar(){

        //Actualizar registros
        $this->actual->update([
                            'status'=>!$this->status
                        ]);

        $this->dispatch('alerta', name:'Se cambio el estado de: '.$this->nombre);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
    }

    /**
     * Reglas de validación
     */
    protected $rules = [

        'salario_id'    => 'required',
        'user_id'       => 'required',
        'contrato_id'   => 'required',
        'nombre'        => 'required',
        'anio'          => 'required',
        'inicia'        => 'required',
        'observaciones' => 'required',
        'status'        => 'required',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
            'salario_id',
            'user_id',
            'contrato_id',
            'nombre',
            'anio',
            'inicia',
            'finaliza',
            'observaciones',
            'status',
        );

    }

    // Crear Registro
    public function new(){

        $this->emplenombre();

        // validate
        $this->validate();

        //Crear registro
        Planta::create([
                'salario_id'    => $this->salario_id,
                'user_id'       => $this->user_id,
                'contrato_id'   => $this->contrato_id,
                'nombre'        => $this->nombre,
                'anio'          => $this->anio,
                'inicia'        => $this->inicia,
                'finaliza'      => $this->finaliza,
                'observaciones' => $this->observaciones,
                'status'        => $this->status,
        ]);


        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente el registro de: '.$this->nombre);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');

    }

    // Crea e inactiva el anterior
    public function newregistro(){

        $this->emplenombre();

        // validate
        $this->validate();

        $obs=now()." ".Auth::user()->name.": ".$this->observaciones." ----- ".$this->actual->observaciones;

        //Crear nueva vigencia
        Planta::create([
                'salario_id'    => $this->salario_id,
                'user_id'       => $this->user_id,
                'contrato_id'   => $this->contrato_id,
                'nombre'        => $this->nombre,
                'anio'          => $this->anio,
                'inicia'        => $this->inicia,
                'finaliza'      => $this->finaliza,
                'observaciones' => $obs,
                'status'        => $this->status,
        ]);


        $this->actual->update([
                'observaciones' => $obs,
                'status'        => 0,
            ]);


        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente la nueva vigencia de: '.$this->nombre);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');

    }

    // Editar Registro
    public function edit(){

        $this->emplenombre();

        // validate
        $this->validate();

        $obs=now()." ".Auth::user()->name.": ".$this->observaciones." ----- ".$this->actual->observaciones;

        $this->actual->update([
                'salario_id'    => $this->salario_id,
                'user_id'       => $this->user_id,
                'contrato_id'   => $this->contrato_id,
                'nombre'        => $this->nombre,
                'anio'          => $this->anio,
                'inicia'        => $this->inicia,
                'finaliza'      => $this->finaliza,
                'observaciones' => $obs,
                'status'        => $this->status,
            ]);

        // Notificación
        $this->dispatch('alerta', name:'Se ha actualizado correctamente el registro de: '.$this->nombre);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
    }

    private function emplenombre(){

        if($this->user_id){
            $emple=User::find($this->user_id);

            $this->nombre=$emple->name;
        }else{
            $this->validate();
        }

    }

    private function empleados(){
        return User::whereIn('rol_id',[1,2,3,5,6,10])
                    ->orderBy('name', 'ASC')
                    ->get();
    }

    private function contratos(){
        return Contrato::where('status', 2)
                        ->orderBy('nombre', 'ASC')
                        ->get();
    }

    public function render()
    {
        return view('livewire.humana.planta.plantas-create',[
            'empleados'     => $this->empleados(),
            'contratos'     => $this->contratos()
        ]);
    }
}
