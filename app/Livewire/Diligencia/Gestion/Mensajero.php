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

class Mensajero extends Component
{
    use DiligenciasTrait;
    use UsersTrait;
    use FiltroTrait;
    use WithPagination;

    public $buscar;
    public $busqueda;
    public $filtrocrea=[];
    public $mensafiltro;
    public $ciudad;
    public $ordena='id';
    public $ordenado='ASC';
    public $pages = 15;
    public $elegido;

    public $is_editar=true;
    public $is_foto=false;


    public function mount(){
        $this->claseFiltro(8);
        $this->inicio();
    }

    public function inicio(){
        $this->mensafiltro=Auth::user()->id;
        $this->usuario(Auth::user()->id);
        $this->ciudad=$this->ubicacion->sucursal->ciudad->id;
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

    public function buscando(){
        $this->resetPage();
        $this->busqueda=strtolower($this->buscar);
    }

    public function tipo($id){
        switch ($id) {
            case '1':
                $this->inicio();
                break;

            case '2':
                $this->limpiando();
                break;
        }
    }

    #[On('limpiando')]
    public function limpiando(){
        $this->reset(
            'buscar',
            'busqueda',
            'filtrocrea',
            'mensafiltro',
        );
    }

    #[On('fotografiando')]
    public function fotos(){
        $this->reset(
            'elegido',
            'is_editar',
            'is_foto',
        );
    }

    public function recibe($id){

        $observaciones=now()." ".Auth::user()->name.": Recogio la diligencia. ----- ";
        $actual=Dilimensajero::where('diligencia_id',$id)
                                ->where('user_id', Auth::user()->id)
                                ->wherenot('status', 4)
                                ->orderBy('id', 'DESC')
                                ->first();

        if($actual){
            $actual->update([
                            'status'        =>2,
                            'observaciones' =>$observaciones.$actual->observaciones,
                            'fecha'         =>now()
                        ]);
        }else{

            $dili=Dilimensajero::where('diligencia_id',$id)
                                ->orderBy('id', 'DESC')
                                ->first();

            $dili->update([
                'status'    =>4,
                'observaciones' =>$observaciones.$dili->observaciones
            ]);

            Dilimensajero::create([
                'diligencia_id'     =>$id,
                'user_id'           =>Auth::user()->id,
                'observaciones'     =>$observaciones,
                'status'            =>2,
                'fecha'             =>now()
            ]);

        }





        $detalle=Diligencia::whereId($id)->first();

        $detalle->update([
            'status'    => 3,
            'observaciones' =>$observaciones.$detalle->observaciones
        ]);

        $this->dispatch('alerta', name:'Recibido');
        $this->gestionar([1,3]);
    }

    public function gest($id){
        $this->elegido=$id;
        $this->is_editar=!$this->is_editar;
        $this->is_foto=!$this->is_foto;
    }

    public function render()
    {
        return view('livewire.diligencia.gestion.mensajero',[
            'diligencias'   => $this->gestionar([1,3]),
        ]);
    }
}
