<?php

namespace App\Livewire\Humana\Inasistencia;

use App\Models\Humana\Inasistencia;
use App\Models\User;
use App\Traits\StatusTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class InasistenciasCreate extends Component
{
    use WithFileUploads;
    use StatusTrait;

    public $user_id;
    public $nombre;
    public $inicia;
    public $finaliza;
    public $dias;
    public $motivo;
    public $justificada;
    public $foto;
    public $soporte = null;
    public $aprobo = null;
    public $actual;
    public $tipo=0;
    public $status;

    public function mount($elegido=null, $tipo=null){
        if($elegido){
            $this->actual=Inasistencia::find($elegido);
            $this->tipo=$tipo;
            $this->valores();
        }
        if($tipo){
            $this->tipo=$tipo;
        }else{
            $this->tipo=0;
            $this->status=1;
        }
    }

    public function valores(){
        $this->user_id      = $this->actual->user_id;
        $this->nombre       = $this->actual->nombre;
        $this->inicia       = $this->actual->inicia;
        $this->finaliza     = $this->actual->finaliza;
        $this->dias         = $this->actual->dias;
        $this->motivo       = $this->actual->motivo;
        $this->justificada  = $this->actual->justificada;
        $this->soporte      = $this->actual->soporte;
        $this->aprobo       = $this->actual->aprobo;
        $this->status       = $this->actual->status;
    }

    //Inactivar Registro
    //Activar evento
    #[On('inactivando')]
    public function inactivar(){

        //Actualizar registros
        $this->actual->update([
                            'status'=>!$this->status
                        ]);

        $this->dispatch('alerta', name:'Se cambio el estado de: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'user_id'   =>'required',
        'nombre'    =>'required',
        'inicia'    =>'required',
        'finaliza'  =>'required',
        'dias'      =>'required',
        'motivo'    =>'required',
        'justificada'   =>'required',
        'foto'      =>'nullable|mimes:jpg,bmp,png,jpeg,pdf',
        'status'    =>'required',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
            'user_id',
            'nombre',
            'inicia',
            'finaliza',
            'dias',
            'motivo',
            'justificada',
            'soporte',
            'status',
        );

    }

    // Crear Registro
    public function new(){

        $this->calculadia();
        $this->emplenombre();
        $this->apruebanombre();
        $this->cargasoporte();

        // validate
        $this->validate();


        //Crear registro
        Inasistencia::create([
                        'user_id'   =>$this->user_id,
                        'nombre'    =>$this->nombre,
                        'inicia'    =>$this->inicia,
                        'finaliza'  =>$this->finaliza,
                        'dias'      =>$this->dias,
                        'motivo'    =>$this->motivo,
                        'justificada'   =>$this->justificada,
                        'soporte'   =>$this->soporte,
                        'aprobo'    =>$this->aprobo,
                        'status'    =>$this->status,
        ]);


        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente la inasistencia de: '.$this->nombre);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');

    }

    // Editar Registro
    public function edit(){

        $this->calculadia();
        $this->emplenombre();
        $this->apruebanombre();
        $this->cargasoporte();

        // validate
        $this->validate();

        $this->actual->update([
            'user_id'   =>$this->user_id,
            'nombre'    =>$this->nombre,
            'inicia'    =>$this->inicia,
            'finaliza'  =>$this->finaliza,
            'dias'      =>$this->dias,
            'motivo'    =>$this->motivo,
            'justificada'   =>$this->justificada,
            'soporte'   =>$this->soporte,
            'aprobo'    =>$this->aprobo,
            'status'    =>$this->status,
        ]);

        // Notificación
        $this->dispatch('alerta', name:'Se ha actualizado correctamente la inasistencia de: '.$this->nombre);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
    }

    private function cargasoporte(){
        if($this->foto){
            $nombre='inasistencias/'.$this->user_id."-".uniqid().".".$this->foto->extension();
            $this->foto->storeAs($nombre);
            $this->soporte=$nombre;
        }
    }

    private function emplenombre(){
        $emple=User::find($this->user_id);

        $this->nombre=$emple->name;
    }

    private function apruebanombre(){
        if(intval($this->status)===1 && $this->aprobo===null){
            $this->aprobo=Auth::user()->name;
        }
    }

    private function calculadia(){

        $inicia=Carbon::create($this->inicia);
        $finaliza=Carbon::create($this->finaliza);

        $this->dias = $inicia->diffInDays($finaliza) + 1;
    }

    private function empleados(){
        return User::whereIn('rol_id',[1,2,3,5,6,10])
                    ->orderBy('name', 'ASC')
                    ->get();
    }

    public function render()
    {
        return view('livewire.humana.inasistencia.inasistencias-create',[
            'empleados' => $this->empleados(),
        ]);
    }
}
