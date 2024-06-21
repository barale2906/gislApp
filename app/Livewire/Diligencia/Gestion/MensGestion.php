<?php

namespace App\Livewire\Diligencia\Gestion;

use App\Models\Diligencias\Dilifotos;
use App\Models\Diligencias\Diligencia;
use App\Models\Diligencias\Dilimensajero;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class MensGestion extends Component
{
    use WithFileUploads;

    public $actual;
    public $observaciones;
    public $foto;
    public $cobro;
    public $guias;
    public $cierra=1;
    public $status;
    public $statdil;
    public $fecha=null;

    public function mount($elegido){
        $this->actual=Diligencia::find($elegido);
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'observaciones'     => 'required',
        'foto'              => 'nullable|mimes:jpg,bmp,png,jpeg',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
            'foto',
            'observaciones',
        );

    }

    // Editar datos de entrega diligencia
    public function edit(){

        // validate
        $this->validate();

        $observaciones=now()." ".Auth::user()->name.": ".$this->observaciones." guias: ".$this->guias." cobro: $".$this->cobro." ----- ";
        $diligest=Dilimensajero::where('diligencia_id',$this->actual->id)
                                ->where('user_id', Auth::user()->id)
                                ->wherenot('status', 4)
                                ->orderBy('id', 'DESC')
                                ->first();

        if($this->foto){

            $nombre='public/soportes/'.$this->actual->id."-".uniqid().".".$this->foto->extension();
            $this->foto->storeAs($nombre);

            Dilifotos::create([
                'diligencia_id' =>$this->actual->id,
                'user_id'       =>Auth::user()->id,
                'ruta'          =>$nombre
            ]);


        }

        switch ($this->cierra) {
            case '1':
                $this->status=3;
                $this->statdil=2;
                break;

            case '2':
                $this->status=7;
                $this->statdil=3;
                $this->fecha=now();
                break;


            case '3':
                $this->status=8;
                $this->statdil=3;
                $this->fecha=now();
                break;
        }

        //Actualiza Mensajero
        $diligest->update([
            'status'            =>$this->statdil,
            'observaciones'     =>$observaciones.$diligest->observaciones
        ]);

        //Actualiza Diligencia
        $this->actual->update([
            'cobro'             =>$this->cobro+$this->actual->cobro,
            'guias'             =>$this->guias+$this->actual->guias,
            'observaciones'     =>$observaciones.$this->actual->observaciones,
            'status'            =>$this->status,
            'fecha_recepcion'   =>$this->fecha
        ]);

        // Notificación
        $this->dispatch('alerta', name:'Se cargo la observación y/o imagenes.');
        $this->resetFields();

        //refresh
        $this->dispatch('fotografiando');
    }

    public function render()
    {
        return view('livewire.diligencia.gestion.mens-gestion');
    }
}
