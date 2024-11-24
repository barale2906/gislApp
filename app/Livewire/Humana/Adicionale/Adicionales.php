<?php

namespace App\Livewire\Humana\Adicionale;

use App\Models\Humana\Adicionale;
use App\Traits\FiltroTrait;
use App\Traits\StatusTrait;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Adicionales extends Component
{
    use StatusTrait;
    use WithPagination;
    use FiltroTrait;

    public $permiso='hu_adicionalesModify';
    public $buscar;
    public $busqueda;
    public $elegido;
    public $tipo;

    public $ordena='id';
    public $ordenado='ASC';
    public $pages = 15;

    public $is_modify = true;
    public $is_creating = false;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount(){
        $this->claseFiltro(14);
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

    private function adicionales(){
        return Adicionale::buscar($this->busqueda)
                        ->orderBy($this->ordena, $this->ordenado)
                        ->paginate($this->pages);
    }

    public function render()
    {
        return view('livewire.humana.adicionale.adicionales',[
            'adicionales'   => $this->adicionales()
        ]);
    }
}
