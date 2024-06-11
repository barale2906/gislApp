<?php

namespace App\Livewire\Facturacion\Empresa;

use App\Models\Configuracion\Area;
use App\Models\Configuracion\Ciudad;
use App\Models\Facturacion\Empresa;
use App\Models\Facturacion\Sucursal;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class EmpresasModificar extends Component
{
    use WithFileUploads;

    public $nit;
    public $name;
    public $direccion;
    public $telefono;
    public $contacto;
    public $email;
    public $email_facturacion;
    public $metodopago;
    public $logo;
    public $seguimiento;

    public $ciudad_id;
    public $name_suc;
    public $direccion_suc;
    public $sucursales;
    public $areas_id=[];

    public $actual;
    public $tipo=0;
    public $tipo_suc;
    public $status;
    public $sucu_actual;
    public $status_suc;
    public $ciudad_suc_id;

    public $is_sucursales=false;

    public function mount($elegido=null, $tipo=null){
        if($elegido){
            $this->actual=Empresa::find($elegido);
            $this->tipo=$tipo;
            $this->valores();

            $this->is_sucursales=!$this->is_sucursales;
        }
        if($tipo){
            $this->tipo=$tipo;
        }else{
            $this->tipo=0;
        }
    }

    public function valores(){

        $this->nit=                 $this->actual->nit;
        $this->name=                $this->actual->name;
        $this->direccion=           $this->actual->direccion;
        $this->telefono=            $this->actual->telefono;
        $this->contacto=            $this->actual->contacto;
        $this->email=               $this->actual->email;
        $this->email_facturacion=   $this->actual->email_facturacion;
        $this->metodopago=          $this->actual->metodopago;
        $this->ciudad_id=           $this->actual->ciudades[0]->id;
        $this->seguimiento=         $this->actual->seguimiento;

        if($this->actual->status===1){
            $this->status=true;
        }else{
            $this->status=false;
        }

        $this->sucursales=Sucursal::where('empresa_id', $this->actual->id)->orderBy('name')->get();

        $this->tipo_suc=0;

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
        'nit'               => 'required',
        'name'              => 'required',
        'direccion'         => 'required',
        'telefono'          => 'required',
        'contacto'          => 'required',
        'email'             => 'required',
        'email_facturacion' => 'required',
        'metodopago'        => 'required',
        'logo'              => 'nullable|mimes:jpg,bmp,png,jpeg',
        'ciudad_id'         => 'required',
        'seguimiento'       => 'required',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
            'nit',
            'name',
            'direccion',
            'telefono',
            'contacto',
            'email',
            'email_facturacion',
            'metodopago',
            'logo',
            'ciudad_id',
            'seguimiento'
        );

    }

    // Crear Registro
    public function new(){
        // validate
        $this->validate();

        //Verificar que no exista el registro en la base de datos
        $existe=Empresa::Where('nit', '=',strtolower($this->nit))->count();

        if($existe>0){
            $this->dispatch('alerta', name:'Ya existe esta empresa: '.$this->nit);
        } else {

            $nombre=null;


            //Crear registro
            $empr =Empresa::create([
                'nit'               => intval($this->nit),
                'name'              => strtolower($this->name),
                'direccion'         => strtolower($this->direccion),
                'telefono'          => $this->telefono,
                'contacto'          => strtolower($this->contacto),
                'email'             => strtolower($this->email),
                'email_facturacion' => strtolower($this->email_facturacion),
                'metodopago'        => strtolower($this->metodopago),
                'seguimiento'       => $this->seguimiento,
            ]);

            if($this->logo){

                $nombre='public/logos/'.$empr->id."-".uniqid().".".$this->logo->extension();
                $this->logo->storeAs($nombre);

                $empr->update([
                    'logo'              => $nombre
                ]);
            }
            //Asigna ciudad
            DB::table('ciudad_empresa')->insert([
                'ciudad_id'     =>$this->ciudad_id,
                'empresa_id'    =>$empr->id,
                'created_at'    =>now(),
                'updated_at'    =>now()
            ]);

            //Crear sucursal principal
            $area=Area::where('name', 'gerencia')->first();

            $suc=Sucursal::create([
                'name'      =>'principal',
                'direccion' =>$this->direccion,
                'empresa_id'=>$empr->id,
                'ciudad_id' =>$this->ciudad_id
            ]);

            //Asignar primer área.
            DB::table('area_sucursal')->insert([
                    'area_id'       =>$area->id,
                    'sucursal_id'   =>$suc->id,
                    'created_at'    =>now(),
                    'updated_at'    =>now()
                ]);

            //Asignar Superusuarios a la empresa;
            $super=User::where('status', true)
                        ->with('roles')->get()->filter(
                            fn ($user) => $user->roles->where('name', 'Superusuario')->toArray()
                        );

            foreach ($super as $value) {
                        //Asignar empresas
                        DB::table('empresa_user')
                                ->insert([
                                    'empresa_id'    =>$empr->id,
                                    'user_id'       =>$value->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);
                    }

            // Notificación
            $this->dispatch('alerta', name:'Se ha creado correctamente la empresa: '.$this->name);
            $this->resetFields();

            //refresh
            $this->dispatch('refresh');
            $this->actual=Empresa::find($empr->id);
            $this->tipo=1;
            $this->valores();
            $this->is_sucursales=!$this->is_sucursales;
            //$this->dispatch('cancelando');
        }
    }

    public function edit(){
        // validate
        $this->validate();

        $nombre=null;

        //Actualizar registros
        $this->actual->update([
            'direccion'         => strtolower($this->direccion),
            'telefono'          => $this->telefono,
            'contacto'          => strtolower($this->contacto),
            'email'             => strtolower($this->email),
            'email_facturacion' => strtolower($this->email_facturacion),
            'metodopago'        => strtolower($this->metodopago),
            'seguimiento'       => $this->seguimiento,
        ]);

        if($this->logo){

            $nombre='public/logos/'.$this->actual->id."-".uniqid().".".$this->logo->extension();
            $this->logo->storeAs($nombre);

            $this->actual->update([
                'logo'              => $nombre
            ]);
        }

        $this->dispatch('alerta', name:'Se ha modificado correctamente la empresa: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');

    }

    //Mostrar sucursal
    public function show($id, $tipo_suc){
        $this->tipo_suc=$tipo_suc;
        $this->sucu_actual=Sucursal::find($id);

        $this->valorSuc();
    }

    public function valorSuc(){
        $this->name_suc         =$this->sucu_actual->name;
        $this->direccion_suc    =$this->sucu_actual->direccion;
        $this->ciudad_suc_id    =$this->sucu_actual->ciudad_id;

        $ar_id=array();
        foreach ($this->sucu_actual->areas as $value) {
            array_push($ar_id, $value->id);
        }

        $this->areas_id=$ar_id;

        if($this->sucu_actual->status===1){
            $this->status_suc=true;
        }else{
            $this->status_suc=false;
        }
    }

    //Crear sucursales
    public function sucunew(){

        if($this->name_suc && $this->direccion_suc && $this->areas_id){

            $suc=Sucursal::create([
                            'name'      =>strtolower($this->name_suc),
                            'direccion' =>strtolower($this->direccion_suc),
                            'empresa_id'=>$this->actual->id,
                            'ciudad_id' =>$this->ciudad_suc_id
                        ]);

            //Asignar áreas.
            foreach ($this->areas_id as $value) {

                DB::table('area_sucursal')->insert([
                    'area_id'       =>$value,
                    'sucursal_id'   =>$suc->id,
                    'created_at'    =>now(),
                    'updated_at'    =>now()
                ]);
            }


            $this->dispatch('alerta', name:'Se creo correctamente la sucursal: '.$this->name_suc);

            $this->reset('name_suc', 'direccion_suc', 'ciudad_id', 'areas_id');

            $this->valores();

        }else{
            $this->dispatch('alerta', name:'Los campos nombre y dirección de la sucursal son obligatorios. ');
        }
    }

    public function sucuedit(){
        if($this->name_suc && $this->direccion_suc && $this->areas_id){

            $this->sucu_actual->update([
                                        'name'      =>strtolower($this->name_suc),
                                        'direccion' =>strtolower($this->direccion_suc),
                                        'ciudad_id' =>$this->ciudad_suc_id

                                        ]);

            //Eliminar áreas anteriores
            DB::table('area_sucursal')
                ->where('sucursal_id', $this->sucu_actual->id)
                ->delete();

            //Asignar áreas.
            foreach ($this->areas_id as $value) {

                DB::table('area_sucursal')->insert([
                    'area_id'       =>$value,
                    'sucursal_id'   =>$this->sucu_actual->id,
                    'created_at'    =>now(),
                    'updated_at'    =>now()
                ]);
            }


            $this->dispatch('alerta', name:'Se actualizo correctamente la sucursal: '.$this->name_suc);

            $this->reset('name_suc', 'direccion_suc', 'ciudad_id', 'areas_id', 'sucu_actual', 'status_suc');

            $this->valores();

        }else{
            $this->dispatch('alerta', name:'Los campos nombre, ciudad y dirección de la sucursal son obligatorios. ');
        }
    }

    public function sucinac(){

        $this->sucu_actual->update([
                                        'status'      =>!$this->status_suc,
                                    ]);

        $this->valores();
        $this->dispatch('alerta', name:'Se actualizo correctamente la sucursal: '.$this->name_suc);
        $this->reset('name_suc', 'direccion_suc', 'ciudad_suc_id', 'areas_id', 'sucu_actual', 'status_suc');
    }

    public function cancelar(){
        $this->reset('name_suc', 'direccion_suc', 'ciudad_suc_id', 'areas_id', 'sucu_actual', 'status_suc');
        $this->tipo_suc=0;
    }

    private function ciudades(){
        return Ciudad::where('status', true)
                        ->orderBy('name')
                        ->get();
    }

    private function areas(){
        return Area::where('status', true)->orderBy('name')->get();
    }
    public function render()
    {
        return view('livewire.facturacion.empresa.empresas-modificar',[
            'ciudades'  =>$this->ciudades(),
            'areas'     =>$this->areas()
        ]);
    }
}
