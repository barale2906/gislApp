<?php

namespace App\Livewire\Facturacion\Factura;

use App\Models\Diligencias\Diligencia;
use App\Models\Facturacion\Empresa;
use App\Models\Facturacion\Factura;
use App\Models\Facturacion\FacturaDetalle;
use App\Models\Facturacion\ListaEmpresa;
use App\Models\Facturacion\Producto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class FacturaItem extends Component
{
    use WithFileUploads;

    public $cliente;
    public $lista;
    public $elementos;
    public $elepro;
    public $unidades;
    public $observaciones;
    public $precio;
    public $nombre_producto;
    public $idetalle;
    public $factura;
    public $detinf;
    public $zip;
    public $numerofactura;
    public $status=1;

    public $is_detalles=true;
    public $is_factura=false;
    public $is_aprobar=false;
    public $is_eliminar=false;
    public $is_cargazip=false;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount($factura=null){
        if($factura){
            $this->factura=Factura::find($factura);
            $this->status=$this->factura->status;
            $this->fijas();
        }
    }

    public function updatedCliente(){

        $this->factura=Factura::where('empresa_id',$this->cliente)
                                ->where('status', 1)
                                ->first();


        if($this->factura){
            $this->fijas();
        }else{
            $this->valida();
        }
    }

    public function valida(){

        $this->lista=ListaEmpresa::where('status', 3)
                                    ->where('empresa_id',$this->cliente)
                                    ->first();

        if($this->lista){
            $this->elementos=Producto::join('lista_detalles', 'productos.id', '=', 'lista_detalles.producto_id')
                                        ->where('lista_detalles.lista_id',$this->lista->lista_id)
                                        ->select('productos.name', 'lista_detalles.producto_id', 'lista_detalles.precio')
                                        ->orderBy('productos.name', 'ASC')
                                        ->get();


        }else{
            $this->dispatch('alerta', name:'No tiene lista de precios.');
            $this->clean();
        }
    }

    public function fijas(){

        $this->lista=ListaEmpresa::where('status', 3)
                                    ->where('empresa_id',$this->factura->empresa_id)
                                    ->where('lista_id', $this->factura->lista_id)
                                    ->first();

        $this->elementos=Producto::join('lista_detalles', 'productos.id', '=', 'lista_detalles.producto_id')
                                    ->where('lista_detalles.lista_id',$this->lista->lista_id)
                                    ->select('productos.name', 'lista_detalles.producto_id', 'lista_detalles.precio')
                                    ->orderBy('productos.name', 'ASC')
                                    ->get();

        $this->cliente=$this->factura->empresa_id;
        $this->infodeta();

    }

    public function infodeta(){

        $this->detinf=DB::table('factura_detalles')
                        ->where('factura_id', $this->factura->id)
                        ->selectRaw('concepto, unitario, sum(cantidad) as cantidad, sum(total) as total, sum(descuento_total) as descuento_total')
                        ->groupBy('concepto', 'unitario')
                        ->orderBy('concepto', 'ASC')
                        ->get();


        $this->is_factura=true;
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'cliente'   => 'required',
        'elepro'  => 'required',
        'unidades'  => 'required'
    ];

    public function generar(){
        // validate
        $this->validate();

        if($this->elementos->count()===0){
            $this->elementos=Producto::join('lista_detalles', 'productos.id', '=', 'lista_detalles.producto_id')
                                        ->where('lista_detalles.lista_id',$this->lista->lista_id)
                                        ->select('productos.name', 'lista_detalles.producto_id', 'lista_detalles.precio')
                                        ->orderBy('productos.name', 'ASC')
                                        ->get();
        }

        foreach ($this->elementos as $value) {
            if($value->producto_id===intval($this->elepro)){
                $this->precio=$value->precio;
                $this->nombre_producto=$value->name;
            }
        }

        $total=$this->unidades*$this->precio;
        $descuento=$this->precio*$this->lista->descuento/100;
        $descuentoTotal=$descuento*$this->unidades;

        $this->factura=Factura::create([
            'lista_id'      => $this->lista->lista_id,
            'empresa_id'    => $this->lista->empresa_id,
            'empresa'       => $this->lista->empresa,
            'total'         => $total,
            'descuento'     => $descuentoTotal,
            'user_id'       => Auth::user()->id,
            'fecha'         => now(),
            'vencimiento'   => now()
        ]);

        FacturaDetalle::create([
            'factura_id'        =>$this->factura->id,
            'producto_id'       =>$this->elepro,
            'concepto'          =>$this->nombre_producto,
            'cantidad'          =>$this->unidades,
            'unitario'          =>$this->precio,
            'total'             =>$total,
            'descuento'         =>$descuento,
            'descuento_total'   =>$descuentoTotal,
            'observaciones'     =>$this->observaciones
        ]);

        $this->reset(
            'elepro',
            'unidades',
            'precio',
            'nombre_producto',
            'observaciones'
        );
        $this->infodeta();
    }

    public function anexar(){

        if($this->elementos->count()===0){
            $this->elementos=Producto::join('lista_detalles', 'productos.id', '=', 'lista_detalles.producto_id')
                                        ->where('lista_detalles.lista_id',$this->lista->lista_id)
                                        ->select('productos.name', 'lista_detalles.producto_id', 'lista_detalles.precio')
                                        ->orderBy('productos.name', 'ASC')
                                        ->get();
        }

        foreach ($this->elementos as $value) {
            if($value->producto_id===intval($this->elepro)){
                $this->precio=$value->precio;
                $this->nombre_producto=$value->name;
            }
        }

        $total=$this->unidades*$this->precio;
        $descuento=$this->precio*$this->lista->descuento/100;
        $descuentoTotal=$descuento*$this->unidades;


        FacturaDetalle::create([
            'factura_id'        =>$this->factura->id,
            'producto_id'       =>$this->elepro,
            'concepto'          =>$this->nombre_producto,
            'cantidad'          =>$this->unidades,
            'unitario'          =>$this->precio,
            'total'             =>$total,
            'descuento'         =>$descuento,
            'descuento_total'   =>$descuentoTotal,
            'observaciones'     =>$this->observaciones
        ]);


        $this->factura->update([
            'total'     =>$this->factura->total+$total,
            'descuento' =>$this->factura->descuento+$descuentoTotal,
        ]);

        $this->reset(
            'elepro',
            'unidades',
            'precio',
            'nombre_producto',
            'observaciones'
        );
        $this->infodeta();
    }

    public function show($item){

        $this->idetalle         =FacturaDetalle::find($item);
        $this->elepro           =$this->idetalle->producto_id;
        $this->unidades         =$this->idetalle->cantidad;
        $this->observaciones    =$this->idetalle->observaciones;

        if($this->elementos->count()===0){
            $this->elementos=Producto::join('lista_detalles', 'productos.id', '=', 'lista_detalles.producto_id')
                                        ->where('lista_detalles.lista_id',$this->lista->lista_id)
                                        ->select('productos.name', 'lista_detalles.producto_id', 'lista_detalles.precio')
                                        ->orderBy('productos.name', 'ASC')
                                        ->get();
        }

        $this->is_factura=false;

    }

    public function aprobar(){
        $this->is_aprobar=true;
    }

    public function cierrafactura(){

        if($this->observaciones && $this->numerofactura){
            //Actualizar factura

            $this->factura->update([
                'numero'        =>$this->numerofactura,
                'status'        =>2,
                'observaciones' =>$this->observaciones
            ]);

            //Actualizar diligencia sin requerimiento
            Diligencia::where('seguimiento', false)
                        ->where('empresa_id', $this->factura->empresa_id)
                        ->where('status_factura',1)
                        ->update([
                            'status_factura'    =>3,
                            'numero_fac'        =>$this->factura->id
                        ]);

            //Actualizar diligencias cargadas
            Diligencia::where('numero_fac', $this->factura->id)
                        ->update([
                            'status_factura'    =>3
                        ]);
            //Cargar Cartera

            $this->reset('observaciones','numerofactura');
            $this->dispatch('alerta', name:'Se aprobo la factura, cargue el archivo de soporte.');
            $this->infodeta();

            $this->is_cargazip=true;
        }else{
            $this->dispatch('alerta', name:'El campo de observaciones y numero de factura son obligatorios');
        }

    }

    public function activaelim(){
        $this->is_eliminar=!$this->is_eliminar;
    }

    public function eliminafactura(){

        //Liberar diligencias
        Diligencia::where('numero_fac', $this->factura->id)
                        ->update([
                            'status_factura'    =>1,
                            'numero_fac'        =>null
                        ]);

        //Eliminar detalles
        FacturaDetalle::where('factura_id', $this->factura->id)
                        ->delete();

        //Eliminar factura
        $this->factura->delete();

        $this->dispatch('alerta', name:'Se elimino correctamente la factura.');
        $this->dispatch('cancelando');
    }

    public function delete($item){

        $this->factura->update([
            'total'         =>$this->factura->total-$item['total'],
            'descuento'     =>$this->factura->descuento-$item['descuento_total']
        ]);

        $dato=FacturaDetalle::where('id',$item['id'])->first();

        //Actualiza diligencias
        if($dato->diligencia>0){
            Diligencia::where('id', $dato->diligencia)->update([
                'status_factura'    =>1,
                'numero_fac'        =>null
            ]);
        }

        //Eliminar
        $dato->delete();


        if($this->elementos->count()===0){
            $this->elementos=Producto::join('lista_detalles', 'productos.id', '=', 'lista_detalles.producto_id')
                                        ->where('lista_detalles.lista_id',$this->lista->lista_id)
                                        ->select('productos.name', 'lista_detalles.producto_id', 'lista_detalles.precio')
                                        ->orderBy('productos.name', 'ASC')
                                        ->get();
        }

        $this->infodeta();
    }

    public function modificar(){

        $observaciones=Auth::user()->name.': '.$this->observaciones." ----- ".$this->idetalle->observaciones;

        $this->factura->update([
            'total'         =>$this->factura->total-$this->idetalle->total,
            'descuento'     =>$this->factura->descuento-$this->idetalle->descuento_total
        ]);

        if($this->elementos->count()===0){
            $this->elementos=Producto::join('lista_detalles', 'productos.id', '=', 'lista_detalles.producto_id')
                                        ->where('lista_detalles.lista_id',$this->lista->lista_id)
                                        ->select('productos.name', 'lista_detalles.producto_id', 'lista_detalles.precio')
                                        ->orderBy('productos.name', 'ASC')
                                        ->get();
        }

        foreach ($this->elementos as $value) {
            if($value->producto_id===intval($this->elepro)){
                $this->precio=$value->precio;
                $this->nombre_producto=$value->name;
            }
        }

        $total=$this->unidades*$this->precio;
        $descuento=$this->precio*$this->lista->descuento/100;
        $descuentoTotal=$descuento*$this->unidades;

        $this->idetalle->update([
            'factura_id'        =>$this->factura->id,
            'producto_id'       =>$this->elepro,
            'concepto'          =>$this->nombre_producto,
            'cantidad'          =>$this->unidades,
            'unitario'          =>$this->precio,
            'total'             =>$total,
            'descuento'         =>$descuento,
            'descuento_total'   =>$descuentoTotal,
            'observaciones'     =>$observaciones
        ]);

        $this->factura->update([
            'total'     =>$this->factura->total+$total,
            'descuento' =>$this->factura->descuento+$descuentoTotal,
        ]);

        $this->reset(
            'elepro',
            'unidades',
            'precio',
            'nombre_producto',
            'observaciones',
            'idetalle'
        );

        $this->infodeta();

    }

    public function clean(){
        $this->reset(
            'cliente',
            'elementos',
            'elepro',
            'unidades'
        );
    }

    public function muestrazip(){
        $this->is_cargazip=!$this->is_cargazip;
    }

    public function cargarzip(){

        $nombre='public/facturas/'.$this->factura->id."-".uniqid().".".$this->zip->extension();
        $this->zip->storeAs($nombre);

            $this->factura->update([
                'ruta'         => $nombre
            ]);

            $this->dispatch('alerta', name:'Archvo cargado correctamente.');
            $this->infodeta();

        $this->is_cargazip=!$this->is_cargazip;
    }

    public function anulafactura(){
        if($this->observaciones){
            //Liberar diligencias
            Diligencia::where('numero_fac', $this->factura->id)
            ->update([
                'status_factura'    =>1,
                'numero_fac'        =>null
            ]);

            $this->factura->update([
                'status'        =>4,
                'observaciones' =>Auth::user()->name.' Anulo con: '.$this->observaciones.' ----- '.$this->factura->observaciones,
            ]);


            $this->dispatch('alerta', name:'Se anulo correctamente la factura.');
            $this->dispatch('cancelando');
        }else{
            $this->dispatch('alerta', name:'Es necesario registrar observaciones');
        }
    }

    private function clientes(){
        return Empresa::where('status', true)
                        ->get();
    }

    private function porfacturar(){
        return Diligencia::with('empresa')
                            ->join('empresas','diligencias.empresa_id','=','empresas.id')
                            ->where('diligencias.status_factura', 1)
                            ->where('diligencias.seguimiento', false)
                            ->select('empresas.name')
                            ->groupby('empresas.name')
                            ->get();
    }

    public function render()
    {
        return view('livewire.facturacion.factura.factura-item',[
            'clientes'      => $this->clientes(),
            'porfacturar'   => $this->porfacturar()
        ]);
    }
}
