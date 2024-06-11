<?php

namespace App\Livewire\Configuracion\Area;

use App\Models\Configuracion\Area;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class AreaList extends Component
{
    use WithPagination;

    public $ordena='name';
    public $ordenado='ASC';
    public $pages = 15;

    public $is_modify = true;
    public $is_creating = false;

    public $tipo;
    public $elegido;

    protected $listeners = ['refresh' => '$refresh'];

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

    //Modificar registro
    public function show($id, $est){
        $this->elegido=$id;
        $this->tipo=$est;
        $this->is_modify = !$this->is_modify;
        $this->is_creating = !$this->is_creating;
    }
    private function areas(){
        return Area::orderBy($this->ordena, $this->ordenado)
                    ->paginate($this->pages);
    }
    public function render()
    {
        return view('livewire.configuracion.area.area-list', [
            'areas' => $this->areas()
        ]);
    }
}
