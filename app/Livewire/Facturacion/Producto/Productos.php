<?php

namespace App\Livewire\Facturacion\Producto;

use App\Models\Facturacion\Producto;
use App\Traits\FiltroTrait;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Productos extends Component
{
    use WithPagination;
    use FiltroTrait;

    public $permiso='fa_productomodify';
    public $buscar;
    public $busqueda;

    public $ordena='id';
    public $ordenado='ASC';
    public $pages = 15;

    public $is_modify = true;
    public $is_creating = false;
    public $is_producto = false;

    public $tipo;
    public $elegido;
    public $lista;
    public $producto;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount($lista=null){
        $this->claseFiltro(4);
        if($lista){
            $this->lista=$lista;
        }
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
        $this->tipo=0;
    }

    #[On('limpiando')]
    public function limpiaFiltro(){
        $this->reset(
            'buscar',
            'busqueda'
        );
    }

    #[On('volviendo')]
    public function volver(){
        $this->reset(
            'is_producto',
            'is_modify',
            'producto'
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

    //Cargar a lista de precios
    public function cargar($id){
        $this->is_producto=!$this->producto;
        $this->is_modify = !$this->is_modify;
        $this->producto=$id;
    }

    private function productos(){
        return Producto::buscar($this->busqueda)
                        ->orderBy($this->ordena, $this->ordenado)
                        ->paginate($this->pages);
    }

    public function render()
    {
        return view('livewire.facturacion.producto.productos',[
            'productos'=>$this->productos()
        ]);
    }
}
