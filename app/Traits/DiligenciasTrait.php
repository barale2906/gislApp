<?php

namespace App\Traits;

use App\Models\Diligencias\Diligencia;
use App\Models\Diligencias\Dilimensajero;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

/**
 * Consultas de diligencias compartidas entre componentes Livewire.
 *
 * **Contrato:** las clases que usen este trait deben declarar como propiedades públicas (o accesibles)
 * las variables que consume cada método; no todas las rutas usan todas las propiedades.
 *
 * **Métodos:**
 * - `generalesQuery()` / `generales()`: listados del cliente por pestaña (`is_lista` 1–8), con filtros de fechas y búsqueda.
 * - `gestionar()`: panel de gestión (filtros por ciudad, mensajero, estados de factura, etc.).
 * - `asignados()` / `elegirmensajero()`: ayudas para filtro de mensajeros.
 * - `historial()`: asignaciones del mensajero seleccionado (si el componente no redefine el método).
 *
 * @property int $is_lista Pestaña activa del listado (1–8). Solo usado por `generalesQuery()` / `generales()`.
 * @property \App\Models\Configuracion\Ubica|null $ubica Ubicación del usuario. Requerida en ramas de “área” (2, 4, 6, 8).
 * @property string|null $busqueda Texto de búsqueda (en varios componentes se guarda en minúsculas).
 * @property array|null $filtrocrea Rango `[desde, hasta]` para el scope `entrega` sobre `fecha_entrega`, o null si no aplica.
 * @property array|null $filtroentrega Rango para el scope `entregado` sobre `fecha_recepción`, o null / vacío si no aplica.
 * @property string $ordena Nombre de columna en `diligencias` para `orderBy` (en `generalesQuery` solo se permiten valores de la lista blanca interna).
 * @property string $ordenado Dirección de orden: `ASC` o `DESC`.
 * @property int $pages Tamaño de página para `paginate()`.
 * @property mixed|null $ciudad Identificador de ciudad para el filtro en `gestionar()`.
 * @property mixed|null $mensafiltro Identificador de usuario mensajero para el filtro en `gestionar()`.
 */
trait DiligenciasTrait
{
    public $nulo;
    public $seleccionados;
    public $mensajero;

    /**
     * Misma consulta que el listado de diligencias del cliente (vista actual), sin paginar.
     *
     * @return Builder<Diligencia>
     */
    public function generalesQuery(): Builder
    {
        $empresaId = Auth::user()->empresa_id;

        $query = match ((int) $this->is_lista) {
            1 => Diligencia::where('status', '<=', 3)
                ->where('empresa_id', $empresaId)
                ->mias(Auth::user()->id)
                ->buscar($this->busqueda)
                ->entrega($this->filtrocrea)
                ->entregado($this->filtroentrega),
            2 => Diligencia::where('status', '<=', 3)
                ->where('empresa_id', $empresaId)
                ->area($this->ubica)
                ->buscar($this->busqueda)
                ->entrega($this->filtrocrea)
                ->entregado($this->filtroentrega),
            3 => Diligencia::where('status', '<=', 3)
                ->where('empresa_id', $empresaId)
                ->miallega(Auth::user()->id)
                ->buscar($this->busqueda)
                ->entrega($this->filtrocrea)
                ->entregado($this->filtroentrega),
            4 => Diligencia::where('status', '<=', 3)
                ->where('empresa_id', $empresaId)
                ->areallega($this->ubica)
                ->buscar($this->busqueda)
                ->entrega($this->filtrocrea)
                ->entregado($this->filtroentrega),
            5 => Diligencia::where('status', '>=', 1)
                ->where('empresa_id', $empresaId)
                ->mias(Auth::user()->id)
                ->buscar($this->busqueda)
                ->entrega($this->filtrocrea)
                ->entregado($this->filtroentrega),
            6 => Diligencia::where('status', '>=', 1)
                ->where('empresa_id', $empresaId)
                ->area($this->ubica)
                ->buscar($this->busqueda)
                ->entrega($this->filtrocrea)
                ->entregado($this->filtroentrega),
            7 => Diligencia::where('status', '>=', 1)
                ->where('empresa_id', $empresaId)
                ->miallega(Auth::user()->id)
                ->buscar($this->busqueda)
                ->entrega($this->filtrocrea)
                ->entregado($this->filtroentrega),
            8 => Diligencia::where('status', '>=', 1)
                ->where('empresa_id', $empresaId)
                ->areallega($this->ubica)
                ->buscar($this->busqueda)
                ->entrega($this->filtrocrea)
                ->entregado($this->filtroentrega),
            default => Diligencia::whereRaw('0 = 1'),
        };

        $allowedOrden = [
            'id', 'identificador', 'status', 'created_at', 'fecha_entrega', 'name_dest', 'sucursal_dest',
            'area_dest', 'direccion_dest', 'guias', 'fecha_recepcion', 'updated_at', 'tipo', 'cobro', 'status_factura',
        ];
        $ordena = in_array($this->ordena, $allowedOrden, true) ? $this->ordena : 'id';
        $ordenado = strtoupper((string) $this->ordenado) === 'DESC' ? 'desc' : 'asc';

        return $query->orderBy('diligencias.'.$ordena, $ordenado);
    }

    /**
     * Listado paginado del cliente según `is_lista` y filtros actuales.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator<int, Diligencia>
     */
    public function generales()
    {
        return $this->generalesQuery()->paginate($this->pages);
    }

    /**
     * Diligencias para gestión o facturación según rango de `status` y filtros opcionales.
     *
     * @param  array{0: int, 1: int}  $status  Par `[desde, hasta]` para `whereBetween` en `diligencias.status`.
     * @param  mixed|null  $nulo  Si es truthy, omite filtros de factura pendiente (`status_factura`, `numero_fac`).
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator<int, Diligencia>
     */
    public function gestionar($status, $nulo=null){
        if($nulo){
            return Diligencia::whereBetween('status', $status)
                            ->buscar($this->busqueda)
                            ->entrega($this->filtrocrea)
                            ->ciudad($this->ciudad)
                            ->mensajero($this->mensafiltro)
                            ->where('seguimiento', true)
                            ->orderBy($this->ordena, $this->ordenado)
                            ->paginate($this->pages);
        }else{
            return Diligencia::whereBetween('status', $status)
                            ->buscar($this->busqueda)
                            ->entrega($this->filtrocrea)
                            ->ciudad($this->ciudad)
                            ->mensajero($this->mensafiltro)
                            ->where('status_factura', 1)
                            ->where('numero_fac', null)
                            ->where('seguimiento', true)
                            ->orderBy($this->ordena, $this->ordenado)
                            ->paginate($this->pages);
        }


    }

    public function asignados(){
        $ids=array();

        $mensajeros=Dilimensajero::whereIn('status', [1,2])
                                    ->select('user_id')
                                    ->groupBy('user_id')
                                    ->get();

        foreach ($mensajeros as $value) {
            if(in_array($value->user_id, $ids)){

            }else{
                array_push($ids, $value->user_id);
            }
        }

        $this->seleccionados = User::whereIn('id',$ids)
                                    ->select('id','name')
                                    ->orderBy('name', 'ASC')
                                    ->get();
    }

    public function elegirmensajero($id){
        $this->mensajero=$id;
    }

    public function historial(){
        if ($this->mensajero) {
            return Dilimensajero::where('user_id',$this->mensajero)
                                ->buscar($this->busqueda)
                                ->entrega($this->filtrocrea)
                                ->whereBetween('status', [1,3])
                                ->orderBy($this->ordena, $this->ordenado)
                                ->paginate($this->pages);
        }

    }
}
