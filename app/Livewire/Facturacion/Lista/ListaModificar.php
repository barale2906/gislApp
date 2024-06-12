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
    public $tipo;

    public $is_modifica=false;

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
        }

    }

    #[On('volviendo')]
    public function volver(){
        $this->reset(
            'is_modifica',
            'detalle'
        );
        $this->valores();
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
