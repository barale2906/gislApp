<?php

namespace App\Livewire\Facturacion\Empresa;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EligeEmpresa extends Component
{
    public $empresas;

    public function mount($user=null){
        if($user){
            $id=$user;
        }else{
            $id=Auth::user()->id;
        }
        $this->empresas=User::find($id);
    }

    public function elegir($id){

        $this->empresas->update([
            'empresa_id'=>$id
        ]);

        $this->dispatch('alerta', name:'Se ha cambiado correctamente la empresa al Usuario: '.$this->empresas->name);
        $this->dispatch('refresh');

        $this->reload($this->empresas->id);

    }

    public function reload($id){
        $this->empresas=User::find($id);
    }
    public function render()
    {
        return view('livewire.facturacion.empresa.elige-empresa');
    }
}
