<?php

namespace App\Livewire\Financiera\Cartera;

use App\Models\Financiera\Cartera;
use App\Traits\FiltroTrait;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Carteras extends Component
{
    use WithPagination;
    use FiltroTrait;

    public $permiso='fi_carterasModify';
    public $buscar;
    public $busqueda;

    public $ordena='factura_id';
    public $ordenado='DESC';
    public $pages = 15;

    public $is_modify = true;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount(){
        $this->claseFiltro(12);
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

    #[On('limpiando')]
    public function limpiaFiltro(){
        $this->reset(
            'buscar',
            'busqueda'
        );
    }

    private function carteras(){
        return Cartera::buscar($this->busqueda)
                        ->orderBy($this->ordena, $this->ordenado)
                        ->paginate($this->pages);
    }

    public function render()
    {
        return view('livewire.financiera.cartera.carteras',[
            'carteras'  =>$this->carteras()
        ]);
    }
}
