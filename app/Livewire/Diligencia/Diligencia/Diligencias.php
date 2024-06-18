<?php

namespace App\Livewire\Diligencia\Diligencia;

use App\Models\Configuracion\Ubica;
use App\Traits\DiligenciasTrait;
use App\Traits\FiltroTrait;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Diligencias extends Component
{
    use WithPagination;
    use FiltroTrait;
    use DiligenciasTrait;

    public $ordena='status';
    public $ordenado='ASC';
    public $pages = 15;

    public $is_modify = true;
    public $is_creating = false;
    public $is_lista=1;

    public $ubica;

    public $tipo;
    public $elegido;
    public $permiso='di_diligenciaModify';

    public $filtroCreades;
    public $filtroCreahas;
    public $filtrocrea=[];
    public $filtroEntdes;
    public $filtroEnthas;
    public $filtroentrega=[];
    public $buscar;
    public $busqueda;



    protected $listeners = ['refresh' => '$refresh'];

    public function mount(){
        $this->claseFiltro(1);
        $this->ubicar();
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

    //Modificar registro
    public function show($id, $est){
        $this->elegido=$id;
        $this->tipo=$est;

        $this->is_modify=!$this->is_modify;
        $this->is_creating=!$this->is_creating;

    }

    //Actualiza ubicacion
    #[On('ubicando')]
    public function ubicar(){
        $this->ubica=Ubica::where('user_id', Auth::user()->id)
                            ->where('status',true)
                            ->first();
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
            'filtroCreades',
            'filtroCreahas',
            'filtrocrea',
            'filtroEntdes',
            'filtroEnthas',
            'buscar',
            'busqueda'
        );
    }

    public function updatedFiltroCreahas(){
        $crea=array();
        array_push($crea, $this->filtroCreades);
        array_push($crea, $this->filtroCreahas);
        $this->filtrocrea=$crea;
    }

    public function updatedFiltroEnthas(){
        $entrega=array();
        array_push($entrega, $this->filtroEntdes);
        array_push($entrega, $this->filtroEnthas);
        $this->filtroentrega=$entrega;

    }

    public function mostrar($id){

        $this->resetPage();
        $this->limpiaFiltro();
        $this->is_lista=$id;
    }

    public function render()
    {
        return view('livewire.diligencia.diligencia.diligencias', [
            'diligencias'=>$this->generales()
        ]);
    }
}
