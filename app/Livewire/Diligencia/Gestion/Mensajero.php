<?php

namespace App\Livewire\Diligencia\Gestion;

use App\Models\Diligencias\Diligencia;
use App\Models\Diligencias\Dilimensajero;
use App\Traits\DiligenciasTrait;
use App\Traits\FiltroTrait;
use App\Traits\UsersTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Mensajero extends Component
{
    use DiligenciasTrait;
    use UsersTrait;
    use FiltroTrait;
    use WithPagination;

    public $buscar;
    public $busqueda;
    public $filtroCreades;
    public $filtroCreahas;
    public $filtrocrea=[];
    public $mensafiltro;
    public $ciudad;
    public $ordena='id';
    public $ordenado='ASC';
    public $pages = 15;
    public $elegido;

    /** Rango de fechas de entrega (diligencias.fecha_entrega) para el historial del mensajero */
    public $historialFechaDesde;

    public $historialFechaHasta;

    public $is_editar=true;
    public $is_foto=false;
    public $is_historial=false;


    public function mount(){
        $this->claseFiltro(8);
        $this->inicio();
    }

    public function updatedFiltroCreahas(){
        $crea=array();
        array_push($crea, $this->filtroCreades);
        array_push($crea, $this->filtroCreahas);
        $this->filtrocrea=$crea;
    }

    public function updatedHistorialFechaDesde(): void
    {
        $this->resetPage();
    }

    public function updatedHistorialFechaHasta(): void
    {
        $this->resetPage();
    }

    /**
     * Por defecto: día actual (fecha de entrega).
     */
    private function inicializarRangoHistorial(): void
    {
        if (empty($this->historialFechaDesde) || empty($this->historialFechaHasta)) {
            $hoy = Carbon::now()->toDateString();
            $this->historialFechaDesde = $hoy;
            $this->historialFechaHasta = $hoy;
        }
    }

    /**
     * Consulta base del historial (mismo criterio que la tabla y el dashboard).
     */
    private function historialBaseQuery(): Builder
    {
        $query = Dilimensajero::query()
            ->where('dilimensajeros.user_id', $this->mensajero)
            ->buscar($this->busqueda)
            ->whereBetween('dilimensajeros.status', [1, 3]);

        if ($this->historialFechaDesde && $this->historialFechaHasta) {
            $fecha1 = Carbon::parse($this->historialFechaDesde)->startOfDay();
            $fecha2 = Carbon::parse($this->historialFechaHasta)->endOfDay();
            if ($fecha1->gt($fecha2)) {
                [$fecha1, $fecha2] = [
                    Carbon::parse($this->historialFechaHasta)->startOfDay(),
                    Carbon::parse($this->historialFechaDesde)->endOfDay(),
                ];
            }

            $query->whereHas('diligencia', function ($q) use ($fecha1, $fecha2) {
                $q->whereNotNull('diligencias.fecha_entrega')
                    ->whereBetween('diligencias.fecha_entrega', [$fecha1, $fecha2]);
            });
        } else {
            $query->whereRaw('1 = 0');
        }

        return $query;
    }

    /**
     * Métricas del dashboard del historial (mismo período y búsqueda que la tabla).
     *
     * @return array{total: int, total_guias: int|float, guias_cero: int, clientes: \Illuminate\Support\Collection}
     */
    private function metricasHistorialDashboard(): array
    {
        if (! $this->mensajero) {
            return ['total' => 0, 'total_guias' => 0, 'guias_cero' => 0, 'clientes' => collect()];
        }

        $base = $this->historialBaseQuery();

        $total = (clone $base)->count();

        $totalGuias = (clone $base)
            ->join('diligencias', 'dilimensajeros.diligencia_id', '=', 'diligencias.id')
            ->sum('diligencias.guias');

        $guiasCero = (clone $base)->whereHas('diligencia', function ($q) {
            $q->where('diligencias.guias', '<=', 0);
        })->count();

        $clientes = (clone $base)
            ->join('diligencias', 'dilimensajeros.diligencia_id', '=', 'diligencias.id')
            ->join('empresas', 'diligencias.empresa_id', '=', 'empresas.id')
            ->selectRaw('empresas.name as cliente, SUM(diligencias.guias) as guias, COUNT(dilimensajeros.id) as diligencias')
            ->groupBy('empresas.id', 'empresas.name')
            ->orderByDesc('guias')
            ->orderBy('empresas.name')
            ->get();

        return [
            'total' => $total,
            'total_guias' => (int) $totalGuias,
            'guias_cero' => $guiasCero,
            'clientes' => $clientes,
        ];
    }

    /**
     * Historial filtrado por fecha de entrega de la diligencia (evita cargar todo el histórico).
     */
    public function historial()
    {
        if (! $this->mensajero) {
            return Dilimensajero::whereRaw('1 = 0')->paginate($this->pages);
        }

        return $this->historialBaseQuery()
            ->with([
                'diligencia.empresa',
                'diligencia.ubica.user',
            ])
            ->orderBy($this->ordena, $this->ordenado)
            ->paginate($this->pages);
    }

    public function inicio(){
        $this->mensafiltro=Auth::user()->id;
        $this->usuario(Auth::user()->id);
        $this->ciudad=$this->ubicacion->sucursal->ciudad->id;
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

    public function buscando(){
        $this->resetPage();
        $this->busqueda=strtolower($this->buscar);
    }

    public function tipo($id){
        switch ($id) {
            case '1':
                $this->elegirmensajero(Auth::user()->id);
                $this->resetPage();
                $this->inicializarRangoHistorial();
                $this->is_historial=true;
                $this->is_editar=false;
                $this->ordenado='DESC';
                break;
            case '2':
                $this->inicio();
                $this->is_historial=false;
                $this->is_editar=true;
                break;

            case '3':
                $this->limpiando();
                $this->is_historial=false;
                $this->is_editar=true;
                break;
        }
    }

    #[On('limpiando')]
    public function limpiando(){
        $this->reset(
            'buscar',
            'busqueda',
            'filtrocrea',
            'mensafiltro',
        );
    }

    #[On('fotografiando')]
    public function fotos(){
        $this->reset(
            'elegido',
            'is_editar',
            'is_foto',
        );
    }

    public function recibe($id){

        $observaciones=now()." ".Auth::user()->name.": Recogio la diligencia. ----- ";
        $actual=Dilimensajero::where('diligencia_id',$id)
                                ->where('user_id', Auth::user()->id)
                                ->wherenot('status', 4)
                                ->orderBy('id', 'DESC')
                                ->first();

        if($actual){
            $actual->update([
                            'status'        =>2,
                            'observaciones' =>$observaciones.$actual->observaciones,
                            'fecha'         =>now()
                        ]);
        }else{

            $dili=Dilimensajero::where('diligencia_id',$id)
                                ->orderBy('id', 'DESC')
                                ->first();

            if($dili){
                $dili->update([
                    'status'    =>4,
                    'observaciones' =>$observaciones.$dili->observaciones
                ]);
            }


            Dilimensajero::create([
                'diligencia_id'     =>$id,
                'user_id'           =>Auth::user()->id,
                'observaciones'     =>$observaciones,
                'status'            =>2,
                'fecha'             =>now()
            ]);

        }

        $detalle=Diligencia::whereId($id)->first();

        $detalle->update([
            'status'    => 3,
            'observaciones' =>$observaciones.$detalle->observaciones
        ]);

        $this->dispatch('alerta', name:'Recibido');
        $this->gestionar([1,3]);
    }

    public function gest($id){
        $this->elegido=$id;
        $this->is_editar=!$this->is_editar;
        $this->is_foto=!$this->is_foto;
    }

    public function render()
    {
        $data = [
            'diligencias' => $this->gestionar([1, 3]),
        ];

        if ($this->is_historial) {
            $data['historicas'] = $this->historial();
            $data['dashboardHistorial'] = $this->metricasHistorialDashboard();
        } else {
            $data['historicas'] = null;
            $data['dashboardHistorial'] = null;
        }

        return view('livewire.diligencia.gestion.mensajero', $data);
    }
}
