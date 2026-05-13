<?php

namespace App\Livewire\Facturacion\Factura;

use App\Models\Diligencias\Diligencia;
use App\Models\Facturacion\Factura;
use App\Models\Facturacion\FacturaDetalle;
use App\Models\Facturacion\ListaDetalle;
use App\Models\Facturacion\ListaEmpresa;
use App\Models\Facturacion\Producto;
use App\Traits\DiligenciasTrait;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class FacturaDiligencia extends Component
{
    use WithPagination;
    use DiligenciasTrait;

    public $produ;
    public $dili;
    public $listadetalle;
    public $empr;
    public $factura;


    public $ordena='id';
    public $ordenado='ASC';
    public $pages = 100;
    public $busqueda=null;
    public $filtrocrea=null;
    public $ciudad;
    public $mensafiltro;

    public function cargar($item,$empresa){

        $this->dili=Diligencia::find($item);
        $this->factura=Factura::where('empresa_id', $empresa)
                                ->where('status', 1)
                                ->first();

        $this->empr=ListaEmpresa::where('empresa_id',$empresa)
                                    ->where('status', 3)
                                    ->select('lista_id','descuento')
                                    ->first();

        if($this->empr){
            if($this->factura){
                $this->listadetalle=ListaDetalle::where('lista_id',$this->factura->lista_id)
                                                    ->where('producto_id',$this->produ)
                                                    ->first();

                $this->cargadili();
            }else{

                $this->listadetalle=ListaDetalle::where('lista_id',$this->empr->lista_id)
                                                    ->where('producto_id',$this->produ)
                                                    ->first();

                $this->creaFact();
            }

        }else{
            $this->dispatch('alerta', name:'No tiene lista de precios.');
            $this->clean();
        }


    }

    public function creaFact(){

        $this->factura=Factura::create([
            'lista_id'      => $this->listadetalle->lista_id,
            'empresa_id'    => $this->dili->empresa_id,
            'cliente'       => $this->dili->empresa->name,
            'total'         => 0,
            'descuento'     => 0,
            'user_id'       => Auth::user()->id,
            'fecha'         =>now(),
            'vencimiento'   =>now()
        ]);

        $this->cargadili();
    }

    public function cargadili(){

        if($this->listadetalle){

            $total=$this->dili->guias*$this->listadetalle->precio;
            $descuento=$this->listadetalle->precio*$this->empr->descuento/100;
            $descuentoTotal=$descuento*$this->dili->guias;

            FacturaDetalle::create([
                'factura_id'        =>$this->factura->id,
                'diligencia'        =>$this->dili->id,
                'producto_id'       =>$this->produ,
                'concepto'          =>$this->listadetalle->producto->name,
                'cantidad'          =>$this->dili->guias,
                'unitario'          =>$this->listadetalle->precio,
                'total'             =>$total,
                'descuento'         =>$descuento,
                'descuento_total'   =>$descuentoTotal,
                'observaciones'     =>'Diligencia N°: '.$this->dili->id.' - '.$this->dili->identificador
            ]);

            //Actualiza datos de factura
            $this->factura->update([
                'total'     =>$this->factura->total+$total,
                'descuento' =>$this->factura->descuento+$descuentoTotal
            ]);

            //Actualizar diligencia
            $this->dili->update([
                'status_factura'    =>2,
                'numero_fac'        =>$this->factura->id
            ]);
        }else{
            $this->dispatch('alerta', name:'Producto sin precio');
        }
        $this->clean();
    }

    public function desiste($id){
        Diligencia::where('id',$id)->update([
            'status_factura'    =>5
        ]);
        $this->clean();
    }

    public function clean(){
        $this->reset(
            'dili',
            'listadetalle',
            'empr',
            'factura'
        );
    }

    private function productos(){

        return Producto::where('status', true)
                        ->orderBy('name', 'ASC')
                        ->get();
    }

    /**
     * Diligencias pendientes de facturar (mismo criterio que gestionar([4,8])),
     * ordenadas de más antigua a más reciente por fecha_entrega.
     */
    private function diligenciasParaFacturar()
    {
        return Diligencia::query()
            ->whereBetween('diligencias.status', [4, 8])
            ->buscar($this->busqueda)
            ->entrega($this->filtrocrea)
            ->ciudad($this->ciudad)
            ->mensajero($this->mensafiltro)
            ->where('diligencias.status_factura', 1)
            ->whereNull('diligencias.numero_fac')
            ->where('diligencias.seguimiento', true)
            ->with(['empresa:id,name'])
            ->orderByRaw('diligencias.fecha_entrega IS NULL ASC')
            ->orderBy('diligencias.fecha_entrega', 'ASC')
            ->orderBy('diligencias.id', 'ASC')
            ->paginate($this->pages);
    }

    public function render()
    {
        return view('livewire.facturacion.factura.factura-diligencia', [
            'diligencias' => $this->diligenciasParaFacturar(),
            'productos' => $this->productos(),
        ]);
    }
}
