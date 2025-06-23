<?php

namespace App\Livewire\Financiera\Movimiento;

use App\Models\Facturacion\Factura;
use App\Models\Financiera\Banco;
use App\Models\Financiera\Cartera;
use App\Models\Financiera\Concepto;
use App\Models\Financiera\Librodiario;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class MovimientosCreate extends Component
{
    use WithFileUploads;

    public $actual;
    public $tipo=0;
    public $status;

    public $banco_id;
    public $banco_dos;
    public $concepto_id;
    public $concep;
    public $accion;
    public $facturas;
    public $cartera_id;
    public $mensaje;
    public $fecha;
    public $valor;
    public $saldo;
    public $tip;
    public $comentario;
    public $is_bancos=false;
    public $is_facturas=false;
    public $soporte;

    public function mount($elegido=null, $tipo=null){
        if($elegido){
            $this->actual=Librodiario::find($elegido);
            $this->tipo=$tipo;
        }
        if($tipo){
            $this->tipo=$tipo;
        }else{
            $this->tipo=0;
        }
    }

    public function updatedConceptoId(){
        $itm=explode("-",$this->concepto_id);
        $this->concep=intval($itm[0]);
        $this->accion=intval($itm[1]);
        $this->banco_id=intval($this->banco_id);
        if(intval($itm[1])>1){
            $this->accionComport();
        }
    }

    public function accionComport(){
        $this->reset('facturas','is_facturas','is_bancos');
        switch ($this->accion) {
            case 2:
                $this->facturas=Cartera::where('status','<',3)
                                        ->orderBy('cliente','ASC')
                                        ->get();
                $this->is_facturas=true;
                break;
            case 3:
                $this->is_bancos=true;
                break;
        }
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'banco_id'      =>'required',
        'concepto_id'   =>'required',
        'fecha'         =>'required',
        'valor'         =>'required',
        'tip'           =>'required',
        'comentario'    =>'required',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
            'banco_id',
            'concepto_id',
            'fecha',
            'valor',
            'tip',
            'comentario',
            'facturas',
            'is_facturas',
            'is_bancos',
            'saldo',
            'status',
            'mensaje'
        );
    }

    // Crear Registro
    public function new(){

        // validate
        $this->validate();

        $ultima=Librodiario::where('banco_id', $this->banco_id)
                            ->where('status', true)
                            ->first();

        if(intval($this->tip)===1){
            $this->saldo=$ultima->saldo+$this->valor;
        }else{
            $this->saldo=$ultima->saldo-$this->valor;
        }

        //Crear registro
        Librodiario::create([
            'banco_id'=>$this->banco_id,
            'concepto_id'=>$this->concep,
            'fecha'=>$this->fecha,
            'valor'=>$this->valor,
            'saldo'=>$this->saldo,
            'tipo'=>$this->tip,
            'comentario'=>$this->comentario,
        ]);

        $ultima->update([
            'status'=>false
        ]);

        switch ($this->accion) {
            case 1:
                $this->saliendo();
                break;

            case 2:
                $this->pagafactura();
                break;

            case 3:
                $this->trasladonew();
                break;
        }
    }

    public function saliendo(){

        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente el movimiento con fecha: '.$this->fecha.'. '.$this->mensaje);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
    }

    public function trasladonew(){

        $envia=Librodiario::where('banco_id', $this->banco_dos)
                            ->where('status', true)
                            ->first();

        $banrecibe=Banco::find($this->banco_id);
        $observaciones=now()." ".Auth::user()->name." Envío: $ ".$this->valor." a la cuenta: ".$banrecibe->name." con el siguiente comentario: ".$this->comentario;

        //Crear registro
        Librodiario::create([
            'banco_id'=>$this->banco_dos,
            'concepto_id'=>11,
            'fecha'=>$this->fecha,
            'valor'=>$this->valor,
            'saldo'=>$envia->saldo-$this->valor,
            'tipo'=>0,
            'comentario'=>$observaciones,
        ]);

        $envia->update([
            'status'=>false
        ]);

        $this->saliendo();
    }

    public function pagafactura(){

        $cartera=Cartera::find($this->cartera_id);
        $saldo=$cartera->saldo-$this->valor;

        if($saldo>0){
            $this->saldo=$saldo;
            $this->status=2;
            $this->mensaje="Se cargo abono a la factura.";
        }else{
            $this->saldo=0;
            $this->status=3;
            $this->mensaje="Se pago completamente la factura.";
        }

        $cartera->update([
            'saldo'         =>$this->saldo,
            'status'        =>$this->status,
            'comentarios'   =>now()." ".Auth::user()->name.": Se genero pago por: $ ".$this->valor.", ".$this->comentario." ----- ".$cartera->comentarios,
        ]);

        // Actualiza la factura
        Factura::where('id', $cartera->factura_id)
                ->update([
                    'status'=>3
                ]);

        $this->saliendo();
    }

    public function cargasoporte(){

        $nombre='soportesbanco/'.$this->actual->id."-".uniqid()."movimiento.".$this->soporte->extension();
            $this->soporte->storeAs($nombre);

            $this->actual->update([
                'soporte' =>$nombre
            ]);

            // Notificación
            $this->dispatch('alerta', name:'Se ha cargado correctamente el soporte');
            $this->resetFields();

            //refresh
            $this->dispatch('refresh');
            $this->dispatch('cancelando');
    }


    private function bancos(){
        return Banco::where('status', true)
                    ->orderBy('nombre', 'ASC')
                    ->get();
    }

    private function conceptos(){
        return Concepto::where('status', true)
                        ->where('tipo', $this->tip)
                        ->orderBy('concepto', 'ASC')
                        ->get();
    }

    public function render()
    {
        return view('livewire.financiera.movimiento.movimientos-create',[
            'bancos'    =>$this->bancos(),
            'conceptos' =>$this->conceptos()
        ]);
    }
}
