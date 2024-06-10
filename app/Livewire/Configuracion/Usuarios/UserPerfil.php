<?php

namespace App\Livewire\Configuracion\Usuarios;

use App\Models\User;
use Livewire\Component;

class UserPerfil extends Component
{
    public $actual;
    public $conf_password;
    public $password;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount($elegido=null){

        $this->actual=User::find($elegido);

    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'password'      =>'required|min:8',
        'conf_password' =>'required|min:8',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
                        'password',
                        'conf_password',
                    );
    }

    public function resetpassword(){

        // validate
        $this->validate();

        if($this->password===$this->conf_password){
            $this->actual->update([
                'password'=>bcrypt($this->password),
            ]);

            $this->resetFields();
            $this->dispatch('alerta', name:'Se actualizo la contraseña para: '.$this->actual->name);
        }else{
            $this->dispatch('alerta', name:'No coinciden los campos');
        }

    }
    public function render()
    {
        return view('livewire.configuracion.usuarios.user-perfil');
    }
}
