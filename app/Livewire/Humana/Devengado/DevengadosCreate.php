<?php

namespace App\Livewire\Humana\Devengado;

use App\Models\Diligencias\Diligencia;
use App\Models\Diligencias\Dilimensajero;
use App\Models\Financiera\Banco;
use App\Models\Financiera\Concepto;
use App\Models\Financiera\Librodiario;
use App\Models\Humana\AdicionalDevengado;
use App\Models\Humana\Adicionale;
use App\Models\Humana\Devengado;
use App\Models\Humana\Planta;
use App\Models\Humana\Salario;
use App\Models\User;
use App\Traits\StatusTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
    public $adicional_id;
    public $detalle;
    public $adicionales;
    public $adicionaleagrupados;
    public $totadicional;
    public $selecadicional;
    public $cantidad;
    public $adiempleado;
    public $adiempresa;
    public $ibcadicional;
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
    public $valorapagar;
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
    public $banco_id;
    public $concepto_id;
    public $movimiento_banco;
    public $calculo;
    public $observaciones;
    public $status=0;
    public $diligencias;
    public $salarioelegido;
    public $idadicional;
    public $iddiligencia;

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
                        $this->user_id =                $this->actual->user_id;
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
            $this->salaelegido();
            $this->totaliza();
    }

    public function totaliza(){
        $this->valorapagar=$this->actual->basico+$this->actual->rodamiento+$this->actual->subsidio_transporte+$this->adicionales->sum('total')-$this->actual->total_empleado;
    }

    public function salaelegido(){
        $this->salarioelegido=Salario::find($this->actual->salario_id);
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
        if($this->dias>0 && $this->dias<31){
            $planta=Planta::find($this->planta_id);

            $esta=Devengado::where('mes',$this->mes)
                            ->where('anio',$this->anio)
                            ->where('user_id',$planta->user_id)
                            ->where('status',0)
                            ->first();

            if($esta && $esta->count()>0){
                $this->actual=$esta;
                $this->valores();
            }else{
                $salario=Salario::find($planta->salario_id);
                $this->porce();

                $porcdias=$this->dias/30;

                $this->user_id=$planta->user_id;
                $this->basico = $salario->basico*$porcdias;
                $this->subsidio_transporte=$salario->subsidio_transporte*$porcdias;
                $this->rodamiento = $salario->rodamiento*$porcdias;
                $this->dotaciones = $salario->dotaciones*$porcdias;
                $this->salario_id=$salario->id;
                $this->nombre=$planta->nombre;
                $this->observaciones="Se crea registro de pago.";

                if($salario->salud===1){

                    $ibc=($salario->basico+$salario->subsidio_transporte)*$porcdias; //Salud, pensiones, parafiscales, ARL

                    $ib2=$salario->basico*$porcdias; //Prestaciones prima, cesantias, vacaciones

                    $this->salud_empresa =          $this->porcentajesvigentes->porcen_salud*$ibc/100;
                    $this->salud_empleado =         $this->porcentajesvigentes->porcen_salud_emple*$ibc/100;
                    $this->pension_empresa =        $this->porcentajesvigentes->porcen_pension*$ibc/100;
                    $this->pension_empleado =       $this->porcentajesvigentes->porcen_pension_emple*$ibc/100;
                    $this->arl =                    $salario->arl*$ibc/100;
                    $this->cesantias =              $this->porcentajesvigentes->porcen_cesantias*$ib2/100;
                    $this->interesescesantias =     $this->porcentajesvigentes->porcen_interesescesantias*$ib2/100;
                    $this->prima =                  $this->porcentajesvigentes->porcen_prima*$ib2/100;
                    $this->vacaciones =             $this->porcentajesvigentes->porcen_vacaciones*$ib2/100;
                    $this->sena =                   $this->porcentajesvigentes->porcen_sena*$ibc/100;
                    $this->icbf =                   $this->porcentajesvigentes->porcen_icbf*$ibc/100;
                    $this->caja =                   $this->porcentajesvigentes->porcen_caja*$ibc/100;
                }

                $this->totlizainicio();
            }
        }else{
            $this->dispatch('alerta', name:'Días deben estar entre 1 y 30 días.');
        }
    }

    //Totaliza el pago
    public function totlizainicio(){
        $this->total_empresa=$this->basico+$this->subsidio_transporte+$this->rodamiento+$this->dotaciones+$this->salud_empresa+$this->pension_empresa+$this->arl+$this->cesantias+$this->interesescesantias+$this->prima+$this->vacaciones+$this->sena+$this->icbf+$this->caja;

        $this->total_empleado=$this->salud_empleado+$this->pension_empleado;

        $this->new();
    }

    //Adicionales cargados
    public function cargadicionales(){
        $this->reset('adicionales');
        $this->adicionales=AdicionalDevengado::where('devengado_id',$this->actual->id)
                                                ->get();

        $this->adicionaleagrupados=AdicionalDevengado::where('devengado_id',$this->actual->id)
                                                        ->selectRaw('adicional_id, unitario, SUM(cantidad) as total_cantidad, SUM(total) as total_valor')
                                                        ->groupBy('adicional_id','unitario')
                                                        ->get();

        $this->cargaDiligencias();
    }

     //Cargar diligencias
    private function cargaDiligencias(){
        $this->diligencias=Dilimensajero::where('user_id',$this->actual->user_id)
                                            ->where('status',3)
                                            ->finalizada($this->statusfinalizados)
                                            ->whereHas('diligencia')
                                            ->with('diligencia')
                                            ->orderBy(
                                                Diligencia::select('fecha_entrega')
                                                    ->whereColumn('diligencias.id', 'dilimensajeros.diligencia_id'),
                                                'ASC' // o 'desc' según lo que necesites
                                            )
                                            ->get();
        $this->totaliza();
    }

    public function eliminAdicional($item){
        $this->adicional_id=$item['adicional_id'];
        $this->cantidad=$item['cantidad'];
        $this->idadicional=$item['id'];
        $this->iddiligencia=$item['id_diligencia'];

        $this->calculadicional(0,1);
    }

    //Recibe diligencia
    public function recibeDiligencia($value){
        $diligencia = Diligencia::find(intval($value));
        $diligencia->update([
                        'pago_mensajero'    => $this->actual->id
                    ]);

        $this->detalle="Diligencia N°: ".$diligencia->id." fecha: ".$diligencia->fecha_entrega.", del cliente: ".$diligencia->empresa->name." por: ".$diligencia->guias." guías.";
        $this->cantidad=$diligencia->guias;
        $this->calculadicional($diligencia->id,0);
    }

    public function calculadicional($id,$accion){

        $this->selecadicional=Adicionale::find($this->adicional_id);

        switch ($this->selecadicional->aplica) {
            case 0:
                $this->ibcadicional=1;
                break;

            case 1:
                $this->ibcadicional=240;
                break;
        }

        if($this->selecadicional->form_calculo===0){
            $ibc=$this->selecadicional->valor;
            $ib2=$this->selecadicional->valor;
        }else if($this->selecadicional->form_calculo===1){
            $ibc=(($this->salarioelegido->basico+$this->salarioelegido->subsidio_transporte)/$this->ibcadicional)*$this->selecadicional->valor/100; //Salud, pensiones, parafiscales, ARL
            $ib2=($this->salarioelegido->basico/$this->ibcadicional)*$this->selecadicional->valor/100; //Prestaciones prima, cesantias, vacaciones
        }



        $this->observaciones =          now().": Se cargo adicional: ".$this->selecadicional->nombre." ----- ".$this->actual->observaciones;

        switch ($accion) {
            case 0:
                if($this->selecadicional->aplica<2){
                    $this->totadicional =           $ib2;
                    $this->valorapagar =            $this->valorapagar+$this->totadicional;
                    $this->salud_empresa =          $this->actual->salud_empresa+($this->porcentajesvigentes->porcen_salud*$ibc/100)*$this->cantidad;
                    $this->salud_empleado =         $this->actual->salud_empleado+($this->porcentajesvigentes->porcen_salud_emple*$ibc/100)*$this->cantidad;
                    $this->pension_empresa =        $this->actual->pension_empresa+($this->porcentajesvigentes->porcen_pension*$ibc/100)*$this->cantidad;
                    $this->pension_empleado =       $this->actual->pension_empleado+($this->porcentajesvigentes->porcen_pension_emple*$ibc/100)*$this->cantidad;
                    $this->arl =                    $this->actual->arl+($this->salarioelegido->arl*$ibc/100)*$this->cantidad;
                    $this->cesantias =              $this->actual->cesantias+($this->porcentajesvigentes->porcen_cesantias*$ib2/100)*$this->cantidad;
                    $this->interesescesantias =     $this->actual->interesescesantias+($this->porcentajesvigentes->porcen_interesescesantias*$ib2/100)*$this->cantidad;
                    $this->prima =                  $this->actual->prima+($this->porcentajesvigentes->porcen_prima*$ib2/100)*$this->cantidad;
                    $this->vacaciones =             $this->actual->vacaciones+($this->porcentajesvigentes->porcen_vacaciones*$ib2/100)*$this->cantidad;
                    $this->sena =                   $this->actual->sena+($this->porcentajesvigentes->porcen_sena*$ibc/100)*$this->cantidad;
                    $this->icbf =                   $this->actual->icbf+($this->porcentajesvigentes->porcen_icbf*$ibc/100)*$this->cantidad;
                    $this->caja =                   $this->actual->caja+($this->porcentajesvigentes->porcen_caja*$ibc/100)*$this->cantidad;

                    $this->total_empresa=           $this->total_empresa+(($this->porcentajesvigentes->porcen_salud*$ibc/100)*$this->cantidad)+(($this->porcentajesvigentes->porcen_pension*$ibc/100)*$this->cantidad)+(($this->salarioelegido->arl*$ibc/100)*$this->cantidad)+(($this->porcentajesvigentes->porcen_cesantias*$ib2/100)*$this->cantidad)+(($this->porcentajesvigentes->porcen_interesescesantias*$ib2/100)*$this->cantidad)+(($this->porcentajesvigentes->porcen_prima*$ib2/100)*$this->cantidad)+(($this->porcentajesvigentes->porcen_vacaciones*$ib2/100)*$this->cantidad)+(($this->porcentajesvigentes->porcen_sena*$ibc/100)*$this->cantidad)+(($this->porcentajesvigentes->porcen_icbf*$ibc/100)*$this->cantidad)+(($this->porcentajesvigentes->porcen_caja*$ibc/100)*$this->cantidad);

                    $this->total_empleado =         $this->total_empleado+(($this->porcentajesvigentes->porcen_salud_emple*$ibc/100)*$this->cantidad)+(($this->porcentajesvigentes->porcen_pension_emple*$ibc/100)*$this->cantidad);
                }

                if($this->selecadicional->aplica===2){
                    $this->totadicional =           $this->selecadicional->valor;
                    $this->valorapagar =            $this->valorapagar+$this->totadicional;/*
                    $this->salud_empresa =          $this->actual->salud_empresa;
                    $this->salud_empleado =         $this->actual->salud_empleado;
                    $this->pension_empresa =        $this->actual->pension_empresa;
                    $this->pension_empleado =       $this->actual->pension_empleado;
                    $this->cesantias =              $this->actual->cesantias;
                    $this->interesescesantias =     $this->actual->interesescesantias;
                    $this->prima =                  $this->actual->prima;
                    $this->vacaciones =             $this->actual->vacaciones;
                    $this->sena =                   $this->actual->sena;
                    $this->icbf =                   $this->actual->icbf;
                    $this->caja =                   $this->actual->caja; */
                }
                $this->cargarDevengadosAdicional($id);
                break;

            case 1:
                if($this->selecadicional->aplica<2){
                    $this->totadicional =           $ib2;
                    $this->valorapagar =            $this->valorapagar-$this->totadicional;
                    $this->salud_empresa =          $this->actual->salud_empresa-($this->porcentajesvigentes->porcen_salud*$ibc/100)*$this->cantidad;
                    $this->salud_empleado =         $this->actual->salud_empleado-($this->porcentajesvigentes->porcen_salud_emple*$ibc/100)*$this->cantidad;
                    $this->pension_empresa =        $this->actual->pension_empresa-($this->porcentajesvigentes->porcen_pension*$ibc/100)*$this->cantidad;
                    $this->pension_empleado =       $this->actual->pension_empleado-($this->porcentajesvigentes->porcen_pension_emple*$ibc/100)*$this->cantidad;
                    $this->cesantias =              $this->actual->cesantias-($this->porcentajesvigentes->porcen_cesantias*$ib2/100)*$this->cantidad;
                    $this->interesescesantias =     $this->actual->interesescesantias-($this->porcentajesvigentes->porcen_interesescesantias*$ib2/100)*$this->cantidad;
                    $this->prima =                  $this->actual->prima-($this->porcentajesvigentes->porcen_prima*$ib2/100)*$this->cantidad;
                    $this->vacaciones =             $this->actual->vacaciones-($this->porcentajesvigentes->porcen_vacaciones*$ib2/100)*$this->cantidad;
                    $this->sena =                   $this->actual->sena-($this->porcentajesvigentes->porcen_sena*$ibc/100)*$this->cantidad;
                    $this->icbf =                   $this->actual->icbf-($this->porcentajesvigentes->porcen_icbf*$ibc/100)*$this->cantidad;
                    $this->caja =                   $this->actual->caja-($this->porcentajesvigentes->porcen_caja*$ibc/100)*$this->cantidad;
                    $this->total_empresa=           $this->total_empresa-(($this->porcentajesvigentes->porcen_salud*$ibc/100)*$this->cantidad)-(($this->porcentajesvigentes->porcen_pension*$ibc/100)*$this->cantidad)-(($this->salarioelegido->arl*$ibc/100)*$this->cantidad)-(($this->porcentajesvigentes->porcen_cesantias*$ib2/100)*$this->cantidad)-(($this->porcentajesvigentes->porcen_interesescesantias*$ib2/100)*$this->cantidad)-(($this->porcentajesvigentes->porcen_prima*$ib2/100)*$this->cantidad)-(($this->porcentajesvigentes->porcen_vacaciones*$ib2/100)*$this->cantidad)-(($this->porcentajesvigentes->porcen_sena*$ibc/100)*$this->cantidad)-(($this->porcentajesvigentes->porcen_icbf*$ibc/100)*$this->cantidad)-(($this->porcentajesvigentes->porcen_caja*$ibc/100)*$this->cantidad);

                    $this->total_empleado =         $this->total_empleado-(($this->porcentajesvigentes->porcen_salud_emple*$ibc/100)*$this->cantidad)-(($this->porcentajesvigentes->porcen_pension_emple*$ibc/100)*$this->cantidad);
                }

                if($this->selecadicional->aplica===2){
                    $this->totadicional =           $this->selecadicional->valor;
                    $this->valorapagar =            $this->valorapagar+$this->totadicional;
                }
                $this->descargarAdicional();
                break;
        }

    }

    //elimina adicional
    public function descargarAdicional(){

        AdicionalDevengado::where('id',$this->idadicional)
                            ->delete();

        if($this->iddiligencia>0){
            Diligencia::where('id', $this->iddiligencia)
                        ->update([
                            'pago_mensajero' => null
                        ]);
        }


        $this->resetAdicionalFields();
        $this->cargadicionales();
        $this->edit();
    }

    public function cargarDevengadosAdicional($id){
        $total=$this->totadicional*$this->cantidad;
        if($id>0){
            $diligencia=$id;
        }else{
            $diligencia= Null;
        }
        AdicionalDevengado::create([
            'adicional_id'      =>  $this->adicional_id,
            'devengado_id'      =>  $this->actual->id,
            'unitario'          =>  $this->totadicional,
            'cantidad'          =>  $this->cantidad,
            'total'             =>  $total,
            'detalle'           =>  $this->detalle,
            'id_diligencia'     =>  $diligencia,
        ]);

        $this->resetAdicionalFields();

        $this->cargadicionales();

        $this->edit();
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
                'user_id'               =>'required',
                'basico'                =>'required',
                'subsidio_transporte'   =>'required',
                'dias'                  => 'required|min:1|max:30',
                'anio'                  => 'required',
                'mes'                   => 'required',
                'rodamiento'            => 'required',
                'dotaciones'            => 'required',
                'salario_id'            => 'required',
                'nombre'                => 'required',
                'salud_empresa'         => 'required',
                'salud_empleado'        => 'required',
                'pension_empresa'       => 'required',
                'pension_empleado'      => 'required',
                'arl'                   => 'required',
                'cesantias'             => 'required',
                'interesescesantias'    => 'required',
                'prima'                 => 'required',
                'vacaciones'            => 'required',
                'sena'                  => 'required',
                'icbf'                  => 'required',
                'caja'                  => 'required',
                'observaciones'         => 'required',
                'status'                => 'required',
                'foto'                  => 'nullable|mimes:jpg,bmp,png,jpeg,pdf',
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
        $crea=Devengado::create([
                        'user_id' => $this->user_id,
                        'salario_id' => $this->salario_id,
                        'nombre' => $this->nombre,
                        'dias' => $this->dias,
                        'total_empresa' => round($this->total_empresa, 2),
                        'total_empleado' => round($this->total_empleado, 2),
                        'anio' => $this->anio,
                        'mes' => $this->mes,
                        'fecha_pago' => $this->fecha_pago,
                        'basico' => $this->basico,
                        'subsidio_transporte' => $this->subsidio_transporte,
                        'salud_empresa' => round($this->salud_empresa, 2),
                        'salud_empleado' => round($this->salud_empleado, 2),
                        'pension_empresa' => round($this->pension_empresa, 2),
                        'pension_empleado' => round($this->pension_empleado, 2),
                        'arl' => round($this->arl, 2),
                        'cesantias' => round($this->cesantias, 2),
                        'interesescesantias' => round($this->interesescesantias, 2),
                        'prima' => round($this->prima, 2),
                        'vacaciones' => round($this->vacaciones, 2),
                        'dotaciones' => $this->dotaciones,
                        'sena' => round($this->sena, 2),
                        'icbf' => round($this->icbf, 2),
                        'caja' => round($this->caja, 2),
                        'rodamiento' => $this->rodamiento,
                        'soporte_pago' => $this->soporte_pago,
                        'movimiento_banco' => $this->movimiento_banco,
                        'calculo' => $this->calculo,
                        'observaciones' => $this->observaciones,
                        'status' => $this->status,
                ]);


        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente la nómina: '.$this->nombre);
        $this->mount($crea->id);
    }

    // Editar Registro
    public function edit(){

        $this->cargasoporte();

        /* Log::info('user_id: '.$this->user_id.
                ' basico: '                .$this->basico.
                ' subsidio_transporte: '.$this->subsidio_transporte.
                ' dias: '.$this->dias.
                ' anio: '.$this->anio.
                ' mes: '.$this->mes.
                ' rodamiento: '.$this->rodamiento.
                ' dotaciones: '.$this->dotaciones.
                ' salario_id: '.$this->salario_id.
                ' nombre: '.$this->nombre.
                ' salud_empresa: '.$this->salud_empresa.
                ' salud_empleado: '.$this->salud_empleado.
                ' pension_empresa: '.$this->pension_empresa.
                ' pension_empleado: '.$this->pension_empleado.
                ' arl: '.$this->arl.
                ' cesantias: '.$this->cesantias.
                ' interesescesantias: '.$this->interesescesantias.
                ' prima: '.$this->prima.
                ' vacaciones: '.$this->vacaciones.
                ' sena: '.$this->sena.
                ' icbf: '.$this->icbf.
                ' caja: '.$this->caja.
                ' observaciones:'. $this->observaciones.
                ' status: '.$this->status
            ); */

        try {
            // validate
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log validation errors
            Log::error('Validation failed:', [
                'errors' => $e->errors(),
                'message' => $e->getMessage()
            ]);

            // Re-throw the exception so Livewire can handle it normally
            throw $e;
        }

        $this->actual->update([
                'user_id' => $this->user_id,
                'salario_id' => $this->salario_id,
                'nombre' => $this->nombre,
                'dias' => $this->dias,
                'total_empresa' => round($this->total_empresa, 2),
                'total_empleado' => round($this->total_empleado, 2),
                'anio' => $this->anio,
                'mes' => $this->mes,
                'fecha_pago' => $this->fecha_pago,
                'basico' => $this->basico,
                'subsidio_transporte' => $this->subsidio_transporte,
                'salud_empresa' => round($this->salud_empresa, 2),
                'salud_empleado' => round($this->salud_empleado, 2),
                'pension_empresa' => round($this->pension_empresa, 2),
                'pension_empleado' => round($this->pension_empleado, 2),
                'arl' => round($this->arl, 2),
                'cesantias' => round($this->cesantias, 2),
                'interesescesantias' => round($this->interesescesantias, 2),
                'prima' => round($this->prima, 2),
                'vacaciones' => round($this->vacaciones, 2),
                'dotaciones' => round($this->dotaciones, 2),
                'sena' => round($this->sena, 2),
                'icbf' => round($this->icbf, 2),
                'caja' => round($this->caja, 2),
                'rodamiento' => $this->rodamiento,
                'soporte_pago' => $this->soporte_pago,
                'movimiento_banco' => $this->movimiento_banco,
                'calculo' => $this->calculo,
                'observaciones' => $this->observaciones,
                'status' => $this->status,
        ]);

        // Notificación
        //$this->dispatch('alerta', name:'Se ha actualizado correctamente la nómina: '.$this->nombre);

        $this->mount($this->actual->id);
    }

    //REgistrar pago
    public function registraPago(){

        $this->cargasoporte();

        $obs=now().": ".Auth::user()->name." registro el pago y anexo el soporte. ----- ";
        $obspago=now().": ".Auth::user()->name." Pago nomina de: ".$this->nombre;

        $this->actual->update([

                'soporte_pago'  => $this->soporte_pago,
                'observaciones' => $obs.$this->actual->observaciones,
                'fecha_pago'    => $this->fecha_pago,
                'status'        => 1,
        ]);

        $ultima=Librodiario::where('banco_id', $this->banco_id)
                            ->where('status', true)
                            ->first();



        //Crear registro
        Librodiario::create([
            'banco_id'      =>$this->banco_id,
            'concepto_id'   =>$this->concepto_id,
            'fecha'         =>$this->fecha_pago,
            'valor'         =>$this->valorapagar,
            'saldo'         =>$ultima->saldo-$this->valorapagar,
            'tipo'          =>0,
            'comentario'    =>$obspago,
            'soporte'       =>$this->soporte_pago,
        ]);

        $ultima->update([
            'status'=>false
        ]);

        // Notificación
        $this->dispatch('alerta', name:'Se ha actualizado correctamente la nómina: '.$this->actual->nombre);

        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
    }

    private function resetAdicionalFields() {
        $this->reset('adicional_id', 'cantidad', 'detalle');
    }

    private function cargasoporte(){
        if($this->foto){
            $nombre='soportesbanco/'.$this->actual->id."-".uniqid()."devengado.".$this->foto->extension();
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

    private function concepadicionales(){
        return Adicionale::where('status', 2)
                            ->orderBy('nombre', 'ASC')
                            ->get();
    }

    private function conceptos(){
        return Concepto::where('status', true)
                        ->whereIn('id', [14,15])
                        ->orderBy('concepto', 'ASC')
                        ->get();
    }

    private function bancos(){
        return Banco::where('status', true)
                    ->orderBy('nombre', 'ASC')
                    ->get();
    }

    public function render()
    {
        return view('livewire.humana.devengado.devengados-create',[
            'empleados'             => $this->empleados(),
            'concepadicionales'     => $this->concepadicionales(),
            'conceptos'             => $this->conceptos(),
            'bancos'                => $this->bancos()
        ]);
    }
}
