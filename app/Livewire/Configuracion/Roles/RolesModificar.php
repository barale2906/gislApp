<?php

namespace App\Livewire\Configuracion\Roles;

use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesModificar extends Component
{
    public $name = '';
    public $permis = [];
    public $actual;
    public $tipo=0;
    public $status;

    public function mount($elegido=null, $tipo=null){
        if($elegido){
            $this->actual=Role::find($elegido);
            $this->tipo=$tipo;
            $this->valores();
        }
        if($tipo){
            $this->tipo=$tipo;
        }else{
            $this->tipo=0;
        }
    }

    public function valores(){
        $this->name=$this->actual->name;

        foreach ($this->actual->permissions as $value) {
            array_push($this->permis,$value->id);
        }

        if($this->actual->status===1){
            $this->status=true;
        }else{
            $this->status=false;
        }
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
        'name' => 'required|unique:roles|max:100',
        'permis'=>'required',

    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset('name', 'permis');

    }

    // Crear Registro
    public function new(){
        // validate
        $this->validate();

        //Verificar que no exista el registro en la base de datos
        $existe=Role::Where('name', '=',strtolower($this->name))->count();

        if($existe>0){
            $this->dispatch('alerta', name:'Ya existe este rol: '.$this->name);
        } else {

            //Crear registro
            $rol = Role::create([
                'name'=>strtolower($this->name),
            ]);

            //Asignar permisos
            foreach ($this->permis as $value) {
                $vr=intval($value);
                $rol->givePermissionTo($vr);
            }



            // Notificación
            $this->dispatch('alerta', name:'Se ha creado correctamente el rol: '.$this->name);
            $this->resetFields();

            //refresh
            $this->dispatch('refresh');
            $this->dispatch('cancelando');
        }
    }

    public function edit(){

        if($this->name){
            //Actualizar registros
            $this->actual->update([
                'name'=>strtolower($this->name)
            ]);

            //Actualizar permisos
            //$this->actual->permissions()->sync($this->permis);
            $this->actual->syncPermissions($this->permis);

            $this->dispatch('alerta', name:'Se ha modificado correctamente el Rol: '.$this->name);
            $this->resetFields();

            //refresh
            $this->dispatch('refresh');
            $this->dispatch('cancelando');
        }else{
            $this->dispatch('alerta', name:'El campo nombre es obligatorio');
        }



    }

    private function listaPermisos(){
        return Permission::all();
    }

    private function encabezados(){
        return Permission::groupBy('modulo')
                            ->select('modulo')
                            ->get();
    }

    public function render()
    {
        return view('livewire.configuracion.roles.roles-modificar',[
            'listaPermisos'=>$this->listaPermisos(),
            'encabezados'=>$this->encabezados()
        ]);
    }
}
