<?php

namespace App\Livewire\Humana\Devengado;

use App\Models\Humana\Adicionale;
use App\Models\Humana\Devengado;
use App\Models\Humana\Planta;
use App\Models\User;
use App\Traits\StatusTrait;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class DevengadosCreate extends Component
{
    use WithFileUploads;
    use StatusTrait;

    public $user_id;
    public $salario_id;
    public $nombre;
    public $dias;
    public $costo_empresa;
    public $total_empleado;
    public $anio;
    public $mes;
    public $fecha_pago;
    public $seguridad_social_empresa;
    public $seguridad_social_empleado;
    public $provisiones;
    public $soporte_pago;
    public $calculo;
    public $foto;
    public $soporte = null;
    public $actual;
    public $tipo=0;
    public $status=0;
    public $observaciones;
    public $movimiento_banco;

    public function mount($elegido=null, $tipo=null){
        if($elegido){
            $this->actual=Devengado::find($elegido);
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
            $this->user_id = $this->actual->user_id;
            $this->salario_id = $this->actual->salario_id;
            $this->nombre = $this->actual->nombre;
            $this->dias = $this->actual->dias;
            $this->costo_empresa = $this->actual->costo_empresa;
            $this->total_empleado = $this->actual->total_empleado;
            $this->anio = $this->actual->anio;
            $this->mes = $this->actual->mes;
            $this->fecha_pago = $this->actual->fecha_pago;
            $this->seguridad_social_empresa = $this->actual->seguridad_social_empresa;
            $this->seguridad_social_empleado = $this->actual->seguridad_social_empleado;
            $this->provisiones = $this->actual->provisiones;
            $this->soporte_pago = $this->actual->soporte_pago;
            $this->movimiento_banco = $this->actual->movimiento_banco;
            $this->calculo = $this->actual->calculo;
            $this->observaciones = $this->actual->observaciones;
            $this->status = $this->actual->status;
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
                'user_id'                   => 'required',
                'salario_id'                => 'required',
                'nombre'                    => 'required',
                'dias'                      => 'required',
                'costo_empresa'             => 'required',
                'total_empleado'            => 'required',
                'anio'                      => 'required',
                'mes'                       => 'required',
                'fecha_pago'                => 'required',
                'seguridad_social_empresa'  => 'required',
                'seguridad_social_empleado' => 'required',
                'provisiones'               => 'required',
                'soporte_pago'              => 'required',
                'movimiento_banco'          => 'required',
                'calculo'                   => 'required',
                'observaciones'             => 'required',
                'status'                    => 'required',
                'foto'                      => 'nullable|mimes:jpg,bmp,png,jpeg,pdf',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
                'user_id'                   ,
                'salario_id'                ,
                'nombre'                    ,
                'dias'                      ,
                'costo_empresa'             ,
                'total_empleado'            ,
                'anio'                      ,
                'mes'                       ,
                'fecha_pago'                ,
                'seguridad_social_empresa'  ,
                'seguridad_social_empleado' ,
                'provisiones'               ,
                'soporte_pago'              ,
                'movimiento_banco'          ,
                'calculo'                   ,
                'observaciones'             ,
                'status'                    ,
                'foto'
        );

    }

    // Crear Registro
    public function new(){

        $this->emplenombre();
        $this->apruebanombre();
        $this->cargasoporte();

        // validate
        $this->validate();


        //Crear registro
        Devengado::create([
                'user_id'                   => $this->user_id,
                'salario_id'                => $this->salario_id,
                'nombre'                    => $this->nombre,
                'dias'                      => $this->dias,
                'costo_empresa'             => $this->costo_empresa,
                'total_empleado'            => $this->total_empleado,
                'anio'                      => $this->anio,
                'mes'                       => $this->mes,
                'fecha_pago'                => $this->fecha_pago,
                'seguridad_social_empresa'  => $this->seguridad_social_empresa,
                'seguridad_social_empleado' => $this->seguridad_social_empleado,
                'provisiones'               => $this->provisiones,
                'soporte_pago'              => $this->soporte_pago,
                'movimiento_banco'          => $this->movimiento_banco,
                'calculo'                   => $this->calculo,
                'observaciones'             => $this->observaciones,
                'status'                    => $this->status,
                'soporte_pago'              => $this->soporte_pago
            ]);


        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente la nómina: '.$this->nombre);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');

    }

    // Editar Registro
    public function edit(){

        $this->emplenombre();
        $this->apruebanombre();
        $this->cargasoporte();

        // validate
        $this->validate();

        $obs=now()." ".Auth::user()->name.": ".$this->observaciones." ----- ".$this->actual->observaciones;

        $this->actual->update([
            'user_id'                   => $this->user_id,
            'salario_id'                => $this->salario_id,
            'nombre'                    => $this->nombre,
            'dias'                      => $this->dias,
            'costo_empresa'             => $this->costo_empresa,
            'total_empleado'            => $this->total_empleado,
            'anio'                      => $this->anio,
            'mes'                       => $this->mes,
            'fecha_pago'                => $this->fecha_pago,
            'seguridad_social_empresa'  => $this->seguridad_social_empresa,
            'seguridad_social_empleado' => $this->seguridad_social_empleado,
            'provisiones'               => $this->provisiones,
            'soporte_pago'              => $this->soporte_pago,
            'movimiento_banco'          => $this->movimiento_banco,
            'calculo'                   => $this->calculo,
            'observaciones'             => $obs,
            'status'                    => $this->status,
            'soporte_pago'              => $this->soporte_pago
        ]);

        // Notificación
        $this->dispatch('alerta', name:'Se ha actualizado correctamente la nómina: '.$this->nombre);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
    }

    private function cargasoporte(){
        if($this->foto){
            $nombre='inasistencias/'.$this->user_id."-".uniqid().".".$this->foto->extension();
            $this->foto->storeAs($nombre);
            $this->soporte=$nombre;
        }
    }

    private function emplenombre(){

        if($this->user_id){
            $emple=User::find($this->user_id);

            $this->nombre=$emple->name;
        }else{
            $this->validate();
        }

    }

    private function apruebanombre(){
        if(intval($this->status)===1 && $this->aprobo===null){
            $this->calculo=Auth::user()->name;
        }
    }

    private function empleados(){
        return Planta::where('status',1)
                        ->orderBy('nombre','ASC')
                        ->get();
    }

    private function adicionales(){
        return Adicionale::where('status', 2)
                            ->orderBy('nombre', 'ASC')
                            ->get();
    }

    public function render()
    {
        return view('livewire.humana.devengado.devengados-create',[

            'empleados' => $this->empleados(),
            'adicionales'   => $this->adicionales(),
        ]);
    }
}
