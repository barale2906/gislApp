<?php

namespace App\Livewire\Facturacion\Factura;

use App\Models\Facturacion\Factura;
use App\Traits\FiltroTrait;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Facturas extends Component
{
    use WithPagination;
    use FiltroTrait;

    public $permiso='fa_facturamodify';
    public $buscar;
    public $busqueda;

    public $filtroIniciades;
    public $filtroIniciahas;
    public $filtroInicia=[];

    public $filtroTerminades;
    public $filtroTerminahas;
    public $filtroTermina=[];

    public $ordena='status';
    public $ordenado='ASC';
    public $pages = 15;

    public $is_modify = true;
    public $is_creating = false;
    public $is_modificar = false;

    public $tipo;
    public $factura;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount(){
        $this->claseFiltro(5);
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
                        'is_modificar',
                        'tipo',
                        'factura'
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
            'busqueda',
            'filtroIniciades',
            'filtroIniciahas',
            'filtroInicia',
            'filtroTerminades',
            'filtroTerminahas',
            'filtroTermina'
        );
    }

    public function updatedFiltroIniciahas(){
        $crea=array();
        array_push($crea, $this->filtroIniciades);
        array_push($crea, $this->filtroIniciahas);
        $this->filtroInicia=$crea;
    }

    public function updatedFiltroTerminahas(){
        $entrega=array();
        array_push($entrega, $this->filtroTerminades);
        array_push($entrega, $this->filtroTerminahas);
        $this->filtroTermina=$entrega;

    }
    //Modificar registro
    public function show($id, $est){
        $this->cancela();
        $this->factura=$id;
        $this->tipo=$est;
        $this->is_modify = !$this->is_modify;
        $this->is_modificar = !$this->is_modificar;
    }

    private function facturas(){
        return Factura::buscar($this->busqueda)
                        ->orderBy($this->ordena, $this->ordenado)
                        ->paginate($this->pages);
    }

    public function render()
    {
        return view('livewire.facturacion.factura.facturas',[
            'facturas'=>$this->facturas(),
        ]);
    }
}
