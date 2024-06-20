<?php

namespace App\Livewire\Diligencia\Gestion;

use App\Models\Diligencias\Diligencia;
use App\Models\Diligencias\Dilimensajero;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MensGestion extends Component
{
    public $actual;
    public $observaciones;
    public $foto;
    public $cobro;
    public $guias;
    public $cierra;

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

        $observaciones=now()." ".Auth::user()->name.": Actualizo datos (soporte, guías, cobros). ----- ";
        $diligest=Dilimensajero::where('diligencia_id',$this->actual->id)
                                ->where('user_id', Auth::user()->id)
                                ->wherenot('status', 4)
                                ->orderBy('id', 'DESC')
                                ->first();

        if($this->foto){

            $nombre='public/soportes/'.$this->actual->id."-".uniqid().".".$this->foto->extension();
            $this->foto->storeAs($nombre);


        }

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
