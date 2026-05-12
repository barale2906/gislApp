<?php

namespace App\Livewire\Facturacion\Lista;

use App\Models\Facturacion\Empresa;
use App\Models\Facturacion\Lista;
use App\Models\Facturacion\ListaDetalle;
use App\Models\Facturacion\ListaEmpresa;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ListaModificar extends Component
{
    #[Validate('required')]
    public $name;
    public $descripcion;
    public $inicia;
    public $finaliza;
    public $lista;
    public $status;

    public $actual;
    public $detalle;
    public $cargados;
    public $empresas;
    public $remit;
    public $descuento;
    public $tipo;

    public $is_modifica=false;
    public $is_empresas=1;

    public $conflictos=[];
    public $is_confirmaActivar=false;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount($elegido=null, $tipo=null){
        if($elegido){
            $this->actual=Lista::find($elegido);
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
        $this->name=                $this->actual->name;
        $this->descripcion=         $this->actual->descripcion;
        $this->inicia=              $this->actual->inicia;
        $this->finaliza=            $this->actual->finaliza;
        $this->lista=               $this->actual->id;

        if($this->actual->status===1){
            $this->status=true;
        }else{
            $this->status=false;
        }

        $this->detalles();
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
        'name'              => 'required|unique:productos.name',
        'descripcion'       => 'required',
        'inicia'            => 'required',
        'finaliza'          => 'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
            'name',
            'descripcion',
            'inicia',
            'finaliza'
        );

    }

    // Crear Registro
    public function new(){
        // validate
        $this->validate();

        if($this->inicia<$this->finaliza){
            //Crear
            $nueva=Lista::create([
                'name'              => strtolower($this->name),
                'descripcion'       => strtolower($this->descripcion),
                'inicia'            => $this->inicia,
                'finaliza'          => $this->finaliza
            ]);

            $this->actual=$nueva;
            $this->tipo=1;


            $this->dispatch('alerta', name:'Se ha creado correctamente la lista: '.$this->name);
            $this->resetFields();

            //refresh
            $this->dispatch('refresh');
            $this->valores();
        }else{
            $this->dispatch('alerta', name:'La fecha de inicio debe ser menor a la fecha de finalización.');
        }

    }

    public function edit(){

        $this->actual->update([
            'name'              => strtolower($this->name),
            'descripcion'       => strtolower($this->descripcion),
            'inicia'            => $this->inicia,
            'finaliza'          => $this->finaliza
        ]);

        $this->dispatch('alerta', name:'Se ha modificado correctamente la lista: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->valores();
    }

    public function show($id,$est){

        switch ($est) {
            case '1':
                $this->detalle=$id;
                $this->is_modifica=!$this->is_modifica;
                break;

            case '2':
                $this->is_empresas=2;
                break;

            case '3':
                $this->is_empresas=3;
                break;

            case '4':
                $this->remit=$id;
                break;
        }

    }

    #[On('volviendo')]
    public function volver(){
        $this->reset(
            'is_modifica',
            'detalle',
            'remit',
            'is_empresas'
        );
        $this->valores();
    }

    #[On('remitiendo')]
    public function remitir(){
        $this->reset(
            'remit',
            'descuento'
        );
        $this->is_empresas=2;
    }

    public function detalles(){
        $this->cargados=ListaDetalle::where('lista_id', $this->actual->id)
                                        ->get();

        $this->clientes();
    }

    public function clientes(){
        $this->empresas=ListaEmpresa::where('lista_id', $this->actual->id)
                                        ->orderBy('empresa', 'ASC')
                                        ->get();
    }

    public function elimremi($id){
        ListaEmpresa::where('id',$id)
                    ->delete();

        $this->dispatch('alerta', name:'Se elimino del listado');
        $this->volver();
    }

    public function aprobar($id){

        $this->actual->update([
            'status'=>$id
        ]);

        ListaEmpresa::where('lista_id',$this->lista)->update([
            'status'=>$id
        ]);

        if($id===0){
            $this->dispatch('alerta', name:'Se actualizo la lista');
            $this->dispatch('cancelando');
        }else{
            $this->dispatch('alerta', name:'Se actualizo la lista');
            $this->valores();
        }
    }

    /**
     * Valida si los clientes de la lista actual están en alguna lista activa.
     * Retorna un arreglo con los conflictos encontrados.
     */
    private function validarClientesActivos(){
        $empresaIds = ListaEmpresa::where('lista_id', $this->actual->id)
                                    ->pluck('empresa_id')
                                    ->toArray();

        if(empty($empresaIds)){
            return [];
        }

        return ListaEmpresa::join('listas', 'listas.id', '=', 'lista_empresas.lista_id')
                            ->whereIn('lista_empresas.empresa_id', $empresaIds)
                            ->where('lista_empresas.lista_id', '!=', $this->actual->id)
                            ->where('listas.status', '>', 0)
                            ->select(
                                'lista_empresas.empresa as empresa',
                                'listas.name as lista',
                                'listas.status as estado'
                            )
                            ->orderBy('listas.name')
                            ->orderBy('lista_empresas.empresa')
                            ->get()
                            ->map(function($item){
                                return [
                                    'empresa' => $item->empresa,
                                    'lista'   => $item->lista,
                                    'estado'  => $item->estado,
                                ];
                            })
                            ->toArray();
    }

    /**
     * Inicia el proceso de activación de una lista inactiva.
     * Verifica conflictos antes de pedir confirmación.
     */
    public function activarLista(){
        $this->conflictos = $this->validarClientesActivos();

        if(!empty($this->conflictos)){
            $this->is_confirmaActivar = false;
            $this->dispatch('alerta', name:'No se puede activar la lista: hay clientes asignados a otras listas activas.');
            return;
        }

        $this->is_confirmaActivar = true;
    }

    /**
     * Confirma la activación de la lista pasando su estado a Vigente (3).
     * Re-valida los conflictos antes de confirmar.
     */
    public function confirmarActivar(){
        $this->conflictos = $this->validarClientesActivos();

        if(!empty($this->conflictos)){
            $this->is_confirmaActivar = false;
            $this->dispatch('alerta', name:'No se puede activar la lista: hay clientes asignados a otras listas activas.');
            return;
        }

        $this->actual->update([
            'status' => 3
        ]);

        ListaEmpresa::where('lista_id', $this->lista)->update([
            'status' => 3
        ]);

        $this->is_confirmaActivar = false;
        $this->conflictos = [];

        $this->dispatch('alerta', name:'Lista activada correctamente.');
        $this->valores();
    }

    public function cancelarActivar(){
        $this->is_confirmaActivar = false;
        $this->conflictos = [];
    }

    public function limpiarConflictos(){
        $this->conflictos = [];
    }

    private function remitentes(){
        return Empresa::where('status', true)
                        ->orderBy('name', 'ASC')
                        ->get();
    }

    public function render()
    {
        return view('livewire.facturacion.lista.lista-modificar',[
            'remitentes'    =>$this->remitentes()
        ]);
    }
}
