<?php

namespace App\Livewire\Diligencia\Diligencia;

use App\Models\Configuracion\Area;
use App\Models\Configuracion\Ciudad;
use App\Models\Configuracion\Ubica;
use App\Models\Diligencias\Diligencia;
use App\Models\Facturacion\Empresa;
use App\Models\Facturacion\Sucursal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class DiligenciaModificar extends Component
{
    public $name;
    public $ubica_id;
    public $tipo_dili;

    public $actual;
    public $tipo=0;

    public $is_nuevaubi=false;
    public $is_recibir=false;

    public $empresa_id;
    public $seguimiento;
    public $sucursal_id;
    public $sucursal_dest;
    public $area_dest;
    public $area_id;
    public $destinatario_id;
    public $sucursales;
    public $areas;
    public $destinatarios;
    public $ubicactual;
    public $name_dest;
    public $direccion_dest;
    public $ciudad_id;

    public $descripcion;
    public $detalle;
    public $observaciones=[];

    public function mount($elegido=null, $tipo=null){

        if($elegido){
            $this->actual=Diligencia::find($elegido);
            $this->tipo=$tipo;
            $this->valores();

        }
        if($tipo){
            $this->tipo=$tipo;
        }else{
            $this->tipo=0;
        }
        $this->ubicar();
    }

    public function ubicar(){
        $ubica = Ubica::where('user_id', Auth::user()->id)
                                    ->where('status', true)
                                    ->first();

        if($ubica){
            $this->ubicactual=$ubica;
            $this->ubica_id=$ubica->id;
            $this->seguimiento=$ubica->seguimiento;
            $this->empresa_id=$ubica->empresa_id;
            $this->updatedEmpresaId();
        }

    }

    public function valores(){
        $this->observaciones=explode('-----',$this->actual->observaciones);

    }

    public function cambiaUbi(){
        $this->is_nuevaubi=!$this->is_nuevaubi;
    }

    public function updatedEmpresaId(){
        $this->reset('sucursales', 'sucursal_id', 'areas', 'area_id', 'destinatarios', 'destinatario_id');
        $this->sucursales=Sucursal::where('empresa_id', $this->empresa_id)
                                    ->orderBy('name')
                                    ->get();
    }

    public function updatedSucursalId(){
        $this->reset('areas', 'area_id', 'destinatarios', 'destinatario_id');
        $this->areas=Sucursal::find($this->sucursal_id);
    }

    public function updatedAreaId(){
        $this->reset('destinatarios', 'destinatario_id');
        $are=Ubica::where('empresa_id', $this->empresa_id)
                    ->where('sucursal_id', $this->sucursal_id)
                    ->where('area_id', $this->area_id)
                    ->get();

        $ids= array();

        foreach ($are as $value) {
            array_push($ids,$value->user_id);
        }

        $this->destinatarios=User::whereIn('id', $ids)
                                    ->orderBy('name')
                                    ->get();
    }

    public function generaUbi(){

        $empuse=User::find(Auth::user()->id);
        $seguimiento=Empresa::where('id',$this->empresa_id)
                                ->select('seguimiento')
                                ->first();

        //inactivar ubicaciones anteriores
        Ubica::where('user_id', Auth::user()->id)
                ->update([
                    'status'=>false
                ]);
        //verificar si existe la nueva ubicación
        $existe=Ubica::where('empresa_id', $this->empresa_id)
                        ->where('sucursal_id', $this->sucursal_id)
                        ->where('area_id', $this->area_id)
                        ->where('user_id', Auth::user()->id)
                        ->first();

        if($existe){
            $this->ubica_id=$existe->id;
            $this->empresa_id=$existe->empresa_id;
            $this->seguimiento=$existe->seguimiento;
            $existe->update([
                'status'=>true
            ]);
            $empuse->update([
                'empresa_id'=>$existe->empresa_id,
            ]);
            $this->updatedEmpresaId();
        }else{
            $nueva=Ubica::create([
                'empresa_id'=>      $this->empresa_id,
                'sucursal_id'=>     $this->sucursal_id,
                'area_id'=>         $this->area_id,
                'user_id'=>         Auth::user()->id,
                'seguimiento'=>     $seguimiento->seguimiento
            ]);

            $empuse->update([
                'empresa_id'=>$nueva->empresa_id,
            ]);

            $this->ubica_id=$nueva->id;
            $this->empresa_id=$nueva->empresa_id;
            $this->seguimiento=$nueva->seguimiento;
            $this->updatedEmpresaId();
        }


        $this->dispatch('ubicando');
        $this->dispatch('alerta', name:'Se definio la ubicación para: '.Auth::user()->name);
        $this->reset(
            'empresa_id',
            'sucursal_id',
            'area_id',
            'is_nuevaubi'
        );
        $this->ubicar();
    }



    //Inactivar Registro
    //Activar evento
    #[On('inactivando')]
    public function inactivar(){

        //Actualizar registros
        $this->actual->update([
                            'status'            =>9,
                            'observaciones'     =>now()." ".Auth::user()->name." cancelo la diligencia ----- ".$this->actual->observaciones,
                        ]);

        $this->dispatch('alerta', name:'Se cancelo la diligencia N°: '.$this->actual->id);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
    }

    public function registroRecibir(){
        $this->is_recibir=!$this->is_recibir;
    }

    #[On('recibiendo')]
    public function recibir(){
        $this->actual->update([
            'fecha_recepcion'=>now(),
            'observaciones'=>now()." ".Auth::user()->name." Recibio la diligencia con esta observación: ".$this->descripcion.".  ----- ".$this->actual->observaciones,
            'descripcion'=>now()." ".Auth::user()->name." Recibio la diligencia con esta observación: ".$this->descripcion.".  ----- ".$this->actual->descripcion,
            'status'=>6
        ]);

        $this->dispatch('alerta', name:'Se registro la recepción de la diligencia N°: '.$this->actual->id);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
    }


    /**
     * Reglas de validación
     */
    protected $rules = [
        'ubica_id'          => 'required',
        'empresa_id'        => 'required',
        'tipo_dili'         => 'required',
        'name_dest'         => 'required',
        'direccion_dest'    => 'required',
        'ciudad_id'         => 'required',
        'descripcion'       => 'required',
        'detalle'           => 'required',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
                        'ubica_id',
                        'empresa_id',
                        'tipo_dili',
                        'name_dest',
                        'direccion_dest',
                        'ciudad_id',
                        'descripcion',
                        'detalle'
                    );

    }

    // Crear Registro
    public function new(){

        if($this->tipo_dili==="1"){
            if($this->destinatario_id){
                $usuario=User::find($this->destinatario_id);
                $this->name_dest=$usuario->name;

            }else{
                $this->name_dest=Auth::user()->name;
                $this->destinatario_id=Auth::user()->id;
            }



            $this->direccion_dest=$this->areas->direccion." - ".strtoupper($this->areas->name);
            $this->ciudad_id=$this->areas->ciudad_id;
            $this->sucursal_dest=$this->areas->name;

            $are=Area::find($this->area_id);
            $this->area_dest=$are->name;
        }
        // validate
        $this->validate();

        //Crear registro
        $dili=Diligencia::create([
                            'ubica_id'          =>$this->ubica_id,
                            'empresa_id'        =>$this->empresa_id,
                            'tipo'              =>$this->tipo_dili,
                            'dest_id'           =>$this->destinatario_id,
                            'name_dest'         =>$this->name_dest,
                            'sucursal_dest_id'  =>$this->sucursal_id,
                            'sucursal_dest'     =>$this->sucursal_dest,
                            'area_dest_id'      =>$this->area_id,
                            'area_dest'         =>$this->area_dest,
                            'direccion_dest'    =>$this->direccion_dest,
                            'ciudad_id'         =>$this->ciudad_id,
                            'descripcion'       =>strtolower($this->descripcion),
                            'detalle'           =>strtolower($this->detalle),
                            'seguimiento'       =>$this->seguimiento
                        ]);


        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente la diligencia N°: '.$dili->id);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
    }

    private function ciudades(){
        return Ciudad::where('status', true)
                        ->orderBy('name', 'ASC')
                        ->get();
    }

    public function render()
    {
        return view('livewire.diligencia.diligencia.diligencia-modificar', [
            'ciudades'=>$this->ciudades(),
        ]);
    }
}
