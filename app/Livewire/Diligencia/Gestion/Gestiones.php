<?php

namespace App\Livewire\Diligencia\Gestion;

use App\Models\Diligencias\Diligencia;
use App\Models\Diligencias\Dilimensajero;
use App\Traits\DiligenciasTrait;
use App\Traits\FiltroTrait;
use App\Traits\UsersTrait;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Gestiones extends Component
{
    use WithPagination;
    use FiltroTrait;
    use DiligenciasTrait;
    use UsersTrait;

    public $permiso='di_diligenciaModify';

    public $buscar;
    public $busqueda;
    public $filtroCreades;
    public $filtroCreahas;
    public $filtrocrea=[];

    public $ordena='id';
    public $ordenado='ASC';
    public $pages = 15;

    public $is_modify = true;
    public $is_creating = false;

    public $tipo;
    public $elegido;
    public $mensajero;
    public $mensafiltro;
    public $ciudad;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount(){
        $this->claseFiltro(7);
        $this->asignados();
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
            'filtroCreades',
            'filtroCreahas',
            'filtrocrea',
            'buscar',
            'busqueda',
            'usuconsulta',
            'mensajero',
            'ciudad',
            'mensafiltro'
        );
    }

    public function updatedFiltroCreahas(){
        $crea=array();
        array_push($crea, $this->filtroCreades);
        array_push($crea, $this->filtroCreahas);
        $this->filtrocrea=$crea;
    }

    //Modificar registro
    public function show($id, $est){
        $this->cancela();
        $this->elegido=$id;
        $this->tipo=$est;
        $this->is_modify = !$this->is_modify;
        $this->is_creating = !$this->is_creating;
    }

    public function updatedMensajero(){
        $this->usuario($this->mensajero);
        $this->ciudad=$this->ubicacion->sucursal->ciudad->id;
    }

    public function asignar($id){

        $diligencia=Diligencia::find($id);

        $observaciones=Auth::user()->name.": Asigno la diligencia a: ".$this->usuconsulta->name." ----- ";

        $historial=Dilimensajero::where('diligencia_id',$id)
                                    ->orderBy('id', 'DESC')
                                    ->first();

        if($historial){
            $historial->update([
                'status'        =>4,
                'observaciones' =>$observaciones.$historial->observaciones
            ]);
        }



        Dilimensajero::create([
            'diligencia_id'     =>$id,
            'user_id'           =>$this->usuconsulta->id,
            'observaciones'     =>$observaciones
        ]);

        $diligencia->update([
            'status'        =>2,
            'observaciones' =>$observaciones.$diligencia->observaciones
        ]);

        $this->dispatch('alerta', name:'Asignada');
        $this->asignados();
        $this->gestionar([1,3]);
    }

    public function render()
    {
        return view('livewire.diligencia.gestion.gestiones',[
            'diligencias'   => $this->gestionar([1,3]),
            'mensajeros'    => $this->rolusuarios('Mensajero')
        ]);
    }
}
