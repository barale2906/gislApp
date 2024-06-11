<?php

namespace App\Livewire\Facturacion\Empresa;

use App\Models\Facturacion\Empresa;
use App\Traits\FiltroTrait;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Empresas extends Component
{
    use WithPagination;
    use FiltroTrait;

    public $permiso='fa_empresasCrear';
    public $buscar;
    public $busqueda;

    public $ordena='id';
    public $ordenado='ASC';
    public $pages = 15;

    public $is_modify = true;
    public $is_creating = false;

    public $tipo;
    public $elegido;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount(){
        $this->claseFiltro(2);
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
            'buscar',
            'busqueda'
        );
    }

    //Modificar registro
    public function show($id, $est){
        $this->cancela();
        $this->elegido=$id;
        $this->tipo=$est;
        $this->is_modify = !$this->is_modify;
        $this->is_creating = !$this->is_creating;
    }

    private function empresas(){
        return Empresa::buscar($this->busqueda)
                        ->orderBy($this->ordena, $this->ordenado)
                        ->paginate($this->pages);
    }
    public function render()
    {
        return view('livewire.facturacion.empresa.empresas', [
            'empresas'=>$this->empresas()
        ]);
    }
}
