<?php

namespace App\Livewire\Configuracion\Usuarios;

use App\Models\Facturacion\Empresa;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UserModificar extends Component
{
    public $name;
    public $email;
    public $password;
    public $rol_id;
    public $empresa_id = [];
    public $tipUsuario=0;
    public $status = true;

    public $actual;
    public $tipo=0;

    public function mount($elegido=null, $tipo=null){
        if($elegido){
            $this->actual=User::find($elegido);
            $this->tipo=$tipo;
            $this->valores();
        }

        if($tipo){
            $this->tipo=$tipo;
        }else{
            $this->tipo=0;
        }

        $this->tipous();
    }

    public function tipous(){
        if(Auth::user()->rol_id>=2 && Auth::user()->rol_id<=6){
            $this->tipUsuario=1;
        }

        if(Auth::user()->rol_id>6){
            $this->tipUsuario=2;
        }
    }

    public function valores(){

        $this->name=$this->actual->name;
        $this->email=$this->actual->email;
        $this->rol_id=$this->actual->rol_id;
        $this->empresa_id=$this->actual->empresa_id;
        $this->password=$this->actual->password;

        $empresas_id=array();
        foreach ($this->actual->empresas as $value) {
            array_push($empresas_id, $value->id);
            //$this->empresa_id[]=$value->id;
        }

        $this->empresa_id=$empresas_id;

        if($this->actual->status===1){
            $this->status=true;
        }else{
            $this->status=false;
        }
    }

    //Inactivar Registro
    #[On('inactivando')]
    public function inactivar()
    {

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
        'name' => 'required|max:100',
        'email'=>'required|email',
        'password'=>'required|min:8',
        'rol_id'=>'required|integer',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
                        'name',
                        'email',
                        'password',
                        'rol_id',
                        'empresa_id'
                    );
    }

    public function new(){

        // validate
        $this->validate();

        $correo=User::where('email', $this->email)->first();

        if($correo){

            // Notificación
            $this->dispatch('alerta', name:'Ya se ha registrado el correo electrónico: '.$this->email);

        }else{

            for ($i = 0; $i < 1; $i++) {
                $empr=$this->empresa_id[$i];
            }

            //id del rol
            $rolelegido=Role::where('id', $this->rol_id)->first();

            $nuevoUs=User::create([
                                'rol_id'=>$rolelegido->id,
                                'name'=>strtolower($this->name),
                                'email'=>strtolower($this->email),
                                'password'=>bcrypt($this->password),
                                'empresa_id'=>$empr
                            ]);

            $nuevoUs->assignRole($rolelegido->name);

            foreach ($this->empresa_id as $value) {
                //Asignar empresas
                DB::table('empresa_user')
                        ->insert([
                            'empresa_id'    =>$value,
                            'user_id'       =>$nuevoUs->id,
                            'created_at'    =>now(),
                            'updated_at'    =>now()
                        ]);
            }

            // Notificación
            $this->dispatch('alerta', name:'Se ha creado correctamente el Usuario: '.$this->name);
            $this->resetFields();
            $this->dispatch('refresh');
            $this->dispatch('cancelando');
        }
    }

    public function edit(){

        // validate
        $this->validate();

        for ($i = 0; $i < 1; $i++) {
            $empr=$this->empresa_id[$i];
        }


        $rolelegido=Role::where('id', $this->rol_id)->first();

        $this->actual->update([
            'rol_id'=>$this->rol_id,
            'name'=>strtolower($this->name),
            'email'=>strtolower($this->email),
            'empresa_id'=>$empr
        ]);

        //Actualizar Rol
        $this->actual->syncRoles($rolelegido->name);

        //Actualizar empresas
        DB::table('empresa_user')
            ->where('user_id', $this->actual->id)
            ->delete();



        foreach ($this->empresa_id as $value) {
            //Asignar empresas
            DB::table('empresa_user')
                    ->insert([
                        'empresa_id'    =>$value,
                        'user_id'       =>$this->actual->id,
                        'created_at'    =>now(),
                        'updated_at'    =>now()
                    ]);
        }


        // Notificación
        $this->dispatch('alerta', name:'Se ha actualizado correctamente el Usuario: '.$this->name);
        $this->resetFields();
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
    }

    private function roles(){
        return Role::where('status', true)
                    ->orderBy('name')
                    ->get();
    }

    private function empresas(){
        return Empresa::where('status', true)
                        ->orderBy('name')
                        ->get();
    }

    public function render()
    {
        return view('livewire.configuracion.usuarios.user-modificar',[
            'roles'=>$this->roles(),
            'empresas'=>$this->empresas()
        ]);
    }
}
