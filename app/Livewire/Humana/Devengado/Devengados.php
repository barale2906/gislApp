<?php

namespace App\Livewire\Humana\Devengado;

use App\Models\Humana\Devengado;
use App\Traits\FiltroTrait;
use App\Traits\StatusTrait;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Devengados extends Component
{
    use StatusTrait;
    use WithPagination;
    use FiltroTrait;

    public $permiso='hu_inasistenciasModify';
    public $buscar;
    public $busqueda;
    public $elegido;
    public $tipo;

    public $ordena='status';
    public $ordenado='ASC';
    public $pages = 15;

    public $is_modify = true;
    public $is_creating = false;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount(){
        $this->claseFiltro(17);
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

    #[On('limpiando')]
    public function limpiaFiltro(){
        $this->reset(
            'buscar',
            'busqueda'
        );
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

    //Modificar registro
    public function show($id, $est){
        $this->cancela();
        $this->elegido=$id;
        $this->tipo=$est;
        $this->is_modify = !$this->is_modify;
        $this->is_creating = !$this->is_creating;
    }

    private function devengados(){
        return Devengado::buscar($this->busqueda)
                        ->orderBy($this->ordena, $this->ordenado)
                        ->paginate($this->pages);
    }

    public function render()
    {
        return view('livewire.humana.devengado.devengados',[
            'devengados'    => $this->devengados()
        ]);
    }
}
