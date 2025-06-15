<?php

namespace App\Livewire\Humana\Devengado;

use App\Models\Humana\Adicionale;
use App\Models\Humana\Devengado;
use App\Models\Humana\Planta;
use App\Models\Humana\Salario;
use App\Models\User;
use App\Traits\StatusTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class DevengadosCreate extends Component
{
    use WithFileUploads;
    use StatusTrait;

    public $user_id=0;
    public $planta_id;
    public $salario_id;
    public $nombre;
    public $dias;
    public $total_empresa;
    public $total_empleado;
    public $anio;
    public $mes;
    public $fecha_pago;
    public $basico;
    public $subsidio_transporte;
    public $salud_empresa=0;
    public $salud_empleado=0;
    public $pension_empresa=0;
    public $pension_empleado=0;
    public $arl=0;
    public $cesantias=0;
    public $interesescesantias=0;
    public $prima=0;
    public $vacaciones=0;
    public $dotaciones=0;
    public $sena=0;
    public $icbf=0;
    public $caja=0;
    public $rodamiento;
    public $soporte_pago;
    public $movimiento_banco;
    public $calculo;
    public $observaciones;
    public $status=0;

    public $foto;
    public $soporte = null;
    public $actual;
    public $tipo=0;
    public $eleanios;
    public $porcentajesvigentes;

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

        $hoy=now();
        $annio=$hoy->year;
        $this->eleanios=$annio-2;
        $this->calculo=Auth::user()->name;

    }

    public function valores(){
                        $this->user_id =                $this->actual->ser_id;
                        $this->salario_id =             $this->actual->salario_id;
                        $this->nombre =                 $this->actual->nombre;
                        $this->dias =                   $this->actual->dias;
                        $this->total_empresa =          $this->actual->total_empresa;
                        $this->total_empleado =         $this->actual->total_empleado;
                        $this->anio =                   $this->actual->anio;
                        $this->mes =                    $this->actual->mes;
                        $this->fecha_pago =             $this->actual->fecha_pago;
                        $this->basico =                 $this->actual->basico;
                        $this->subsidio_transporte =    $this->actual->subsidio_transporte;
                        $this->salud_empresa =          $this->actual->salud_empresa;
                        $this->salud_empleado =         $this->actual->salud_empleado;
                        $this->pension_empresa =        $this->actual->pension_empresa;
                        $this->pension_empleado =       $this->actual->pension_empleado;
                        $this->arl =                    $this->actual->arl;
                        $this->cesantias =              $this->actual->cesantias;
                        $this->interesescesantias =     $this->actual->interesescesantias;
                        $this->prima =                  $this->actual->prima;
                        $this->vacaciones =             $this->actual->vacaciones;
                        $this->dotaciones =             $this->actual->dotaciones;
                        $this->sena =                   $this->actual->sena;
                        $this->icbf =                   $this->actual->icbf;
                        $this->caja =                   $this->actual->caja;
                        $this->rodamiento =             $this->actual->rodamiento;
                        $this->soporte_pago =           $this->actual->soporte_pago;
                        $this->movimiento_banco =       $this->actual->movimiento_banco;
                        $this->calculo =                $this->actual->calculo;
                        $this->observaciones =          $this->actual->observaciones;
                        $this->status =                 $this->actual->status;

            $this->porce();
            $this->cargadicionales();
    }

    //Porcentajes aplicables
    public function porce(){
        $this->porcentajesvigentes=DB::table('porcentajes_nomina')
                                        ->where('anio',$this->anio)
                                        ->first();
    }

    //Cargar datos del alumno
    public function creardevengado(){
        $this->cargainicial();
        $this->cargadicionales();

        //Buscar prestamos
    }

    public function cargainicial(){
        $planta=Planta::find($this->planta_id);

        $esta=Devengado::where('mes',$this->mes)
                        ->where('anio',$this->anio)
                        ->where('user_id',$planta->user_id)
                        ->first();

        if($esta && $esta->count()>0){
            $this->actual=$esta;
            $this->valores();
        }else{
            $salario=Salario::find($planta->salario_id);
            $this->porce();

            $this->user_id=$planta->user_id;
            $this->basico = $salario->basico;
            $this->subsidio_transporte=$salario->subsidio_transporte;
            $this->rodamiento = $salario->rodamiento;
            $this->dotaciones = $salario->dotaciones;
            $this->salario_id=$salario->id;
            $this->nombre=$planta->empleado->name;

            if($salario->salud===1){

                $ibc=$salario->basico+$salario->subsidio_transporte; //Salud, pensiones, parafiscales, ARL

                $ib2=$salario->basico; //Prestaciones prima, cesantias, vacaciones

                $this->salud_empresa =          $this->porcentajesvigentes->porcen_salud*$ibc/100;
                $this->salud_empleado =         $this->porcentajesvigentes->porcen_salud_emple*$ibc/100;
                $this->pension_empresa =        $this->porcentajesvigentes->porcen_pension*$ibc/100;
                $this->pension_empleado =       $this->porcentajesvigentes->porcen_pension_emple*$ibc/100;
                $this->arl =                    $salario->arl*$ibc/100;
                $this->cesantias =              $this->porcentajesvigentes->porcen_cesantias*$ib2/100;
                $this->interesescesantias =     $this->porcentajesvigentes->interesescesantias*$ib2/100;
                $this->prima =                  $this->porcentajesvigentes->porcen_prima*$ib2/100;
                $this->vacaciones =             $this->porcentajesvigentes->porcen_vacaciones*$ib2/100;
                $this->sena =                   $this->porcentajesvigentes->porcen_sena*$ibc/100;
                $this->icbf =                   $this->porcentajesvigentes->porcen_icbf*$ibc/100;
                $this->caja =                   $this->porcentajesvigentes->porcen_caja*$ibc/100;
            }

            $this->totlizainicio();
        }
    }

    //Totaliza el pago
    public function totlizainicio(){
        $this->total_empresa=$this->basico+$this->subsidio_transporte+$this->rodamiento+$this->dotaciones+$this->salud_empresa+$this->pension_empresa+$this->arl+$this->cesantias+$this->interesescesantias+$this->prima+$this->vacaciones+$this->sena+$this->icbf+$this->caja;

        $this->total_empleado=$this->salud_empleado+$this->pension_empleado;
    }



    //Adicionales cargados
    public function cargadicionales(){

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
            'user_id',
            'salario_id',
            'nombre',
            'dias',
            'total_empresa',
            'total_empleado',
            'anio',
            'mes',
            'fecha_pago',
            'basico',
            'subsidio_transporte',
            'salud_empresa',
            'salud_empleado',
            'pension_empresa',
            'pension_empleado',
            'arl',
            'cesantias',
            'interesescesantias',
            'prima',
            'vacaciones',
            'dotaciones',
            'sena',
            'icbf',
            'caja',
            'rodamiento',
            'soporte_pago',
            'movimiento_banco',
            'calculo',
            'observaciones',
            'status',
            'foto'
        );

    }

    // Crear Registro
    public function new(){

        $this->emplenombre();
        $this->cargasoporte();

        // validate
        $this->validate();


        //Crear registro
        Devengado::create([
                        'user_id' => $this->ser_id,
                        'salario_id' => $this->salario_id,
                        'nombre' => $this->nombre,
                        'dias' => $this->dias,
                        'total_empresa' => $this->total_empresa,
                        'total_empleado' => $this->total_empleado,
                        'anio' => $this->anio,
                        'mes' => $this->mes,
                        'fecha_pago' => $this->fecha_pago,
                        'basico' => $this->basico,
                        'subsidio_transporte' => $this->subsidio_transporte,
                        'salud_empresa' => $this->salud_empresa,
                        'salud_empleado' => $this->salud_empleado,
                        'pension_empresa' => $this->pension_empresa,
                        'pension_empleado' => $this->pension_empleado,
                        'arl' => $this->arl,
                        'cesantias' => $this->cesantias,
                        'interesescesantias' => $this->interesescesantias,
                        'prima' => $this->prima,
                        'vacaciones' => $this->vacaciones,
                        'dotaciones' => $this->dotaciones,
                        'sena' => $this->sena,
                        'icbf' => $this->icbf,
                        'caja' => $this->caja,
                        'rodamiento' => $this->rodamiento,
                        'soporte_pago' => $this->soporte_pago,
                        'movimiento_banco' => $this->movimiento_banco,
                        'calculo' => $this->calculo,
                        'observaciones' => $this->observaciones,
                        'status' => $this->status,
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
            $this->soporte_pago=$nombre;
        }
    }

    private function emplenombre(){

        if($this->user_id){
            $emple=User::find($this->user_id);

            $this->nombre=$emple->name;
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
