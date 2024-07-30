<?php

namespace App\Livewire\Financiera\Movimiento;

use App\Models\Financiera\Banco;
use App\Models\Financiera\Concepto;
use App\Models\Financiera\Librodiario;
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
    public $fecha;
    public $valor;
    public $saldo;
    public $tip;
    public $comentario;

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
            'concepto_id'=>$this->concepto_id,
            'fecha'=>$this->fecha,
            'valor'=>$this->valor,
            'saldo'=>$this->saldo,
            'tipo'=>$this->tip,
            'comentario'=>$this->comentario,
        ]);

        $ultima->update([
            'status'=>false
        ]);


        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente el movimiento con fecha: '.$this->fecha);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');

    }

    public function cargasoporte(){

        $nombre='public/librodiario/'.$this->actual->id."-".uniqid().".".$this->soporte->extension();
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
