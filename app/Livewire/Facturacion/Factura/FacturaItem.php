<?php

namespace App\Livewire\Facturacion\Factura;

use App\Models\Diligencias\Diligencia;
use App\Models\Facturacion\Empresa;
use App\Models\Facturacion\ListaEmpresa;
use App\Models\Facturacion\Producto;
use Livewire\Component;

class FacturaItem extends Component
{
    public $cliente;
    public $lista;
    public $productos;
    public $producto;
    public $cantidad;

    public function updatedCliente(){

        $this->lista=ListaEmpresa::where('status', 3)
                            ->where('empresa_id',$this->cliente)
                            ->first();

        if($this->lista){
            $this->productos=Producto::join('lista_detalles', 'productos.id', '=', 'lista_detalles.producto_id')
                                        ->where('lista_detalles.lista_id',$this->lista->lista_id)
                                        ->orderBy('productos.name', 'ASC')
                                        ->get();
        }else{
            $this->dispatch('alerta', name:'No tiene lista de precios.');
            $this->clean();
        }


    }

    public function clean(){
        $this->reset(
            'cliente',
            'lista',
            'productos',
            'producto',
            'cantidad'
        );
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
