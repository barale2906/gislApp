<?php

namespace App\Livewire\Facturacion\Factura;

use App\Exports\Facturacion\FacturasDashboardExport;
use App\Models\Facturacion\Factura;
use App\Traits\FiltroTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class Facturas extends Component
{
    use WithPagination;
    use FiltroTrait;

    public $permiso='fa_facturamodify';
    public $buscar;
    public $busqueda;

    public $filtroIniciades;
    public $filtroIniciahas;
    public $filtroInicia=[];

    public $filtroTerminades;
    public $filtroTerminahas;
    public $filtroTermina=[];

    /** Filtro por fecha de facturación (`facturas.fecha`) */
    public $facturaFechaDesde;

    public $facturaFechaHasta;

    public $ordena='fecha';
    public $ordenado='DESC';
    public $pages = 100;

    public $is_modify = true;
    public $is_creating = false;
    public $is_modificar = false;

    public $tipo;
    public $factura;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount(){
        $this->claseFiltro(5);
        $this->inicializarRangoFacturas();
    }

    private function inicializarRangoFacturas(): void
    {
        if (empty($this->facturaFechaDesde) || empty($this->facturaFechaHasta)) {
            $hoy = Carbon::now()->toDateString();
            $this->facturaFechaDesde = $hoy;
            $this->facturaFechaHasta = $hoy;
        }
    }

    public function updatedFacturaFechaDesde(): void
    {
        $this->resetPage();
    }

    public function updatedFacturaFechaHasta(): void
    {
        $this->resetPage();
    }

    /**
     * Consulta base del listado y del dashboard (fecha de factura).
     */
    private function facturasBaseQuery(): Builder
    {
        $query = Factura::query()->buscar($this->busqueda);

        if ($this->facturaFechaDesde && $this->facturaFechaHasta) {
            $fecha1 = Carbon::parse($this->facturaFechaDesde)->startOfDay();
            $fecha2 = Carbon::parse($this->facturaFechaHasta)->endOfDay();
            if ($fecha1->gt($fecha2)) {
                [$fecha1, $fecha2] = [
                    Carbon::parse($this->facturaFechaHasta)->startOfDay(),
                    Carbon::parse($this->facturaFechaDesde)->endOfDay(),
                ];
            }

            $query->whereBetween('facturas.fecha', [
                $fecha1->toDateString(),
                $fecha2->toDateString(),
            ]);
        } else {
            $query->whereRaw('1 = 0');
        }

        return $query;
    }

    /**
     * @return array{
     *   valor_facturado: float,
     *   total_facturas: int,
     *   empresas_con_facturas: int,
     *   por_empresa: \Illuminate\Support\Collection,
     *   facturas_anuladas_cantidad: int,
     *   facturas_anuladas_monto_referencia: float,
     *   facturas_anuladas: \Illuminate\Support\Collection
     * }
     */
    private function metricasFacturasDashboard(): array
    {
        $base = $this->facturasBaseQuery();

        /** Solo enviadas (2) y pagadas (3); excluye en proceso (1) y anuladas (4, 5). */
        $valorFacturado = (float) ((clone $base)
            ->whereIn('facturas.status', [2, 3])
            ->selectRaw('COALESCE(SUM(facturas.total - facturas.descuento), 0) as v')
            ->value('v'));

        $totalFacturas = (clone $base)->count();

        $porEmpresa = (clone $base)
            ->select('facturas.empresa_id')
            ->selectRaw('MAX(facturas.cliente) as cliente')
            ->selectRaw('COUNT(*) as cantidad')
            ->selectRaw('SUM(CASE WHEN facturas.status IN (2, 3) THEN facturas.total - facturas.descuento ELSE 0 END) as total_neto')
            ->selectRaw(
                "GROUP_CONCAT(CASE WHEN facturas.status IN (2, 3) THEN CASE WHEN facturas.numero IS NOT NULL THEN CAST(facturas.numero AS CHAR) ELSE CONCAT('P-', facturas.id) END END ORDER BY facturas.fecha SEPARATOR ' · ') as numeros"
            )
            ->groupBy('facturas.empresa_id')
            ->orderByDesc('cantidad')
            ->orderBy('cliente')
            ->get();

        $anuladasBase = (clone $base)->whereIn('facturas.status', [4, 5]);

        $facturasAnuladasCantidad = (clone $anuladasBase)->count();

        $facturasAnuladasMontoReferencia = (float) ((clone $anuladasBase)
            ->selectRaw('COALESCE(SUM(facturas.total - facturas.descuento), 0) as v')
            ->value('v'));

        $facturasAnuladas = (clone $anuladasBase)
            ->select([
                'facturas.id',
                'facturas.cliente',
                'facturas.numero',
                'facturas.fecha',
                'facturas.total',
                'facturas.descuento',
                'facturas.status',
            ])
            ->orderByDesc('facturas.fecha')
            ->orderByDesc('facturas.id')
            ->get();

        return [
            'valor_facturado' => $valorFacturado,
            'total_facturas' => $totalFacturas,
            'empresas_con_facturas' => $porEmpresa->count(),
            'por_empresa' => $porEmpresa,
            'facturas_anuladas_cantidad' => $facturasAnuladasCantidad,
            'facturas_anuladas_monto_referencia' => $facturasAnuladasMontoReferencia,
            'facturas_anuladas' => $facturasAnuladas,
        ];
    }

    public function buscando(){
        $this->resetPage();
        $this->busqueda=strtolower($this->buscar);
    }

    // Ordenar Registros
    public function organizar($campo){
        if($this->ordenado === 'ASC')
        {
            $this->ordenado = 'DESC';
        }else{
            $this->ordenado = 'ASC';
        }
        return $this->ordena = $campo;
    }

    //Numero de registros
    public function paginas($valor){
        $this->resetPage();
        $this->pages=$valor;
    }

    //Activar evento
    #[On('cancelando')]
    //resetear variables
    public function cancela(){
        $this->reset(
                        'is_modify',
                        'is_creating',
                        'is_modificar',
                        'tipo',
                        'factura'
                    );
    }

    //Activar evento
    #[On('created')]
    //Mostrar formulario de creación
    public function updatedIsCreating(){
        $this->is_modify = !$this->is_modify;
        $this->is_creating = !$this->is_creating;
    }

    #[On('limpiando')]
    public function limpiaFiltro(){
        $this->reset(
            'buscar',
            'busqueda',
            'filtroIniciades',
            'filtroIniciahas',
            'filtroInicia',
            'filtroTerminades',
            'filtroTerminahas',
            'filtroTermina'
        );
        $this->inicializarRangoFacturas();
    }

    public function updatedFiltroIniciahas(){
        $crea=array();
        array_push($crea, $this->filtroIniciades);
        array_push($crea, $this->filtroIniciahas);
        $this->filtroInicia=$crea;
    }

    public function updatedFiltroTerminahas(){
        $entrega=array();
        array_push($entrega, $this->filtroTerminades);
        array_push($entrega, $this->filtroTerminahas);
        $this->filtroTermina=$entrega;

    }
    //Modificar registro
    public function show($id, $est){
        $this->cancela();
        $this->factura=$id;
        $this->tipo=$est;
        $this->is_modify = !$this->is_modify;
        $this->is_modificar = !$this->is_modificar;
    }

    private function facturas(){
        $columnaOrden = in_array($this->ordena, ['numero', 'cliente', 'fecha', 'vencimiento', 'total', 'descuento', 'observaciones', 'status'], true)
            ? 'facturas.'.$this->ordena
            : 'facturas.fecha';

        return $this->facturasBaseQuery()
            ->orderByRaw('(facturas.status = 1) DESC')
            ->orderBy($columnaOrden, $this->ordenado)
            ->paginate($this->pages);
    }

    /**
     * Excel con KPI del período, detalle por empresa, anuladas y todas las facturas del filtro actual.
     */
    public function exportarDashboardExcel(): BinaryFileResponse
    {
        Gate::authorize('fa_facturamodify');
        abort_unless($this->is_modify, 403);

        $dashboard = $this->metricasFacturasDashboard();

        $facturas = $this->facturasBaseQuery()
            ->with(['lista:id,name'])
            ->orderByRaw('(facturas.status = 1) DESC')
            ->orderBy('facturas.fecha', 'DESC')
            ->orderBy('facturas.id', 'DESC')
            ->get();

        $desde = (string) ($this->facturaFechaDesde ?? '');
        $hasta = (string) ($this->facturaFechaHasta ?? '');
        $safeDesde = preg_replace('/[^0-9-]/', '', $desde) ?: 'desde';
        $safeHasta = preg_replace('/[^0-9-]/', '', $hasta) ?: 'hasta';

        $fileName = 'facturas_dashboard_'.$safeDesde.'_'.$safeHasta.'.xlsx';

        return Excel::download(
            new FacturasDashboardExport(
                dashboard: $dashboard,
                fechaDesde: $desde,
                fechaHasta: $hasta,
                busqueda: (string) ($this->busqueda ?? ''),
                facturas: $facturas,
            ),
            $fileName
        );
    }

    public function render()
    {
        return view('livewire.facturacion.factura.facturas',[
            'facturas' => $this->facturas(),
            'dashboardFacturas' => $this->is_modify ? $this->metricasFacturasDashboard() : null,
        ]);
    }
}
