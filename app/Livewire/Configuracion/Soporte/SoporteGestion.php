<?php

namespace App\Livewire\Configuracion\Soporte;

use App\Models\Configuracion\Soporte;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class SoporteGestion extends Component
{
    use WithFileUploads;

    public $soportes;
    public $origen;
    public $docuorigen;
    public $propietario_id;
    public $nombre_propietario;
    public $name;
    public $tipo;
    public $fecha_crea;
    public $fecha_vence;
    public $foto;


    public function mount($id,$origen,$propietario){

        $this->origen=$origen;
        $this->propietario_id=$id;
        $this->nombre_propietario=$propietario;
        $this->documentos();
        $this->cargasoporte();
    }

    public function documentos(){
        $this->docuorigen=DB::table('origen_soportes')
                            ->where('origen', $this->origen)
                            ->where('status', true)
                            ->orderBy('name', 'ASC')
                            ->get();
    }

    public function cargasoporte(){
        $this->soportes=Soporte::where('propietario_id',$this->propietario_id)
                                ->where('origen', $this->origen)
                                ->orderBy('tipo', 'ASC')
                                ->orderBy('id', 'DESC')
                                ->get();
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'name' => 'required|max:100',
        'tipo'=>'required',
        'foto'=>'required',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
                        'name',
                        'tipo',
                        'foto',
                        'fecha_crea',
                        'fecha_vence'
                    );
    }

    public function cargar(){

        // validate
        $this->validate();

        $nombre='public/documentos/'.$this->propietario_id."-".uniqid().".".$this->foto->extension();
        $this->foto->storeAs($nombre);

        Soporte::create([
            'origen'=>$this->origen,
            'propietario_id'=>$this->propietario_id,
            'nombre_propietario'=>$this->nombre_propietario,
            'name'=>$this->name,
            'tipo'=>$this->tipo,
            'fecha_crea'=>$this->fecha_crea,
            'fecha_vence'=>$this->fecha_vence,
            'ruta'=>$nombre
        ]);

        // Notificación
        $this->dispatch('alerta', name:'Se ha cargado correctamente el soporte: '.$this->name);
        $this->resetFields();
        $this->cargasoporte();

    }


    public function render()
    {
        return view('livewire.configuracion.soporte.soporte-gestion');
    }
}
