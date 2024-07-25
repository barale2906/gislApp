<?php

namespace App\Livewire\Financiera\Movimiento;

use App\Traits\FiltroTrait;
use App\Traits\MovimientosTrait;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Movimientos extends Component
{
    use WithPagination;
    use FiltroTrait;
    use MovimientosTrait;

    public $permiso='fi_movimientosModify';
    public $buscar;
    public $busqueda;
    public $filtroCreades;
    public $filtroCreahas;
    public $filtrocrea=[];
    public $banco_id;
    public $concepto_id;

    public $ordena='fecha';
    public $ordenado='DESC';
    public $pages = 15;

    public $is_modify = true;
    public $is_creating = false;

    public $tipo;
    public $elegido;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount(){
        $this->claseFiltro(11);
    }

    public function buscando(){
        $this->resetPage();
        $this->busqueda=strtolower($this->buscar);
    }

    // Ordenar Registros
    public function organizar($campo){
        if($this->ordenado === 'ASC')
        {
            $this->ordenado = 'DESC';
        }else{
            $this->ordenado = 'ASC';
        }
        return $this->ordena = $campo;
    }

    //Numero de registros
    public function paginas($valor){
        $this->resetPage();
        $this->pages=$valor;
    }

    public function updatedFiltroCreahas(){
        $crea=array();
        array_push($crea, $this->filtroCreades);
        array_push($crea, $this->filtroCreahas);
        $this->filtrocrea=$crea;
    }

    //Activar evento
    #[On('cancelando')]
    //resetear variables
    public function cancela(){
        $this->reset(
                        'is_modify',
                        'is_creating',
                        'tipo',
                        'elegido'
                    );
        $this->movimi();
    }

    //Activar evento
    #[On('created')]
    //Mostrar formulario de creación
    public function updatedIsCreating(){
        $this->is_modify = !$this->is_modify;
        $this->is_creating = !$this->is_creating;
    }

    #[On('limpiando')]
    public function limpiaFiltro(){
        $this->reset(
            'buscar',
            'busqueda',
            'filtroCreades',
            'filtroCreahas',
            'filtrocrea',
            'banco_id',
            'concepto_id',
        );
    }

    public function filban($id){
        $this->banco_id=$id;
    }

    //Modificar registro
    public function show($id, $est){
        $this->cancela();
        $this->elegido=$id;
        $this->tipo=$est;
        $this->is_modify = !$this->is_modify;
        $this->is_creating = !$this->is_creating;
    }


    public function render()
    {
        return view('livewire.financiera.movimiento.movimientos',[
            'movimientos'   =>$this->movimi(),
            'saldos'        =>$this->saldos(),
            'conceptos'     =>$this->conceptos(),
            'bancos'    =>$this->movibancos(),
        ]);
    }
}
