<?php

namespace App\Livewire\Diligencia\Diligencia;

use App\Exports\Diligencia\DiligenciasClienteExport;
use App\Models\Configuracion\Ubica;
use App\Models\Diligencias\Diligencia;
use App\Models\Facturacion\Empresa;
use App\Traits\DiligenciasTrait;
use App\Traits\FiltroTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class Diligencias extends Component
{
    use WithPagination;
    use FiltroTrait;
    use DiligenciasTrait;

    public $ordena='status';
    public $ordenado='ASC';
    public $pages = 15;

    public $is_modify = true;
    public $is_creating = false;
    public $is_cargar=false;
    public $is_lista=1;

    public $ubica;

    public $tipo;
    public $elegido;
    public $permiso='di_diligenciaModify';

    public $filtroCreades;
    public $filtroCreahas;
    public $filtrocrea=[];
    public $filtroEntdes;
    public $filtroEnthas;
    public $filtroentrega=[];
    public $buscar;
    public $busqueda;



    protected $listeners = ['refresh' => '$refresh'];

    public function mount(){
        $this->claseFiltro(1);
        $this->ubicar();
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

    //Modificar registro
    public function show($id, $est){
        $this->elegido=$id;
        $this->tipo=$est;

        $this->is_modify=!$this->is_modify;
        $this->is_creating=!$this->is_creating;

    }

    //Actualiza ubicacion
    #[On('ubicando')]
    public function ubicar(){
        $this->ubica=Ubica::where('user_id', Auth::user()->id)
                            ->where('status',true)
                            ->first();
    }

    //Activar evento
    #[On('cancelando')]
    //resetear variables
    public function cancela(){
        $this->reset(
                        'is_modify',
                        'is_creating',
                        'is_cargar',
                        'tipo',
                        'elegido'
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
            'filtroCreades',
            'filtroCreahas',
            'filtrocrea',
            'filtroEntdes',
            'filtroEnthas',
            'buscar',
            'busqueda'
        );
    }

    public function updatedFiltroCreahas(){
        $crea=array();
        array_push($crea, $this->filtroCreades);
        array_push($crea, $this->filtroCreahas);
        $this->filtrocrea=$crea;
    }

    public function updatedFiltroEnthas(){
        $entrega=array();
        array_push($entrega, $this->filtroEntdes);
        array_push($entrega, $this->filtroEnthas);
        $this->filtroentrega=$entrega;

    }

    public function mostrar($id){

        $this->resetPage();
        $this->limpiaFiltro();
        $this->is_lista=$id;
    }

    public function impor(){
        $this->is_modify=!$this->is_modify;
        $this->is_cargar=!$this->is_cargar;
    }

    /**
     * Exporta a Excel todas las diligencias de la empresa del usuario (sin filtro por pestaña, búsqueda ni fechas de la pantalla).
     */
    public function exportarDiligenciasExcel(): BinaryFileResponse
    {
        Gate::authorize('di_diligencias');

        $empresaId = Auth::user()->empresa_id;
        abort_if($empresaId === null, 403);

        $diligencias = Diligencia::query()
            ->where('diligencias.empresa_id', $empresaId)
            ->with([
                'empresa:id,name',
                'ubica.user:id,name',
                'ubica.sucursal:id,name',
                'ubica.area:id,name',
                'ciudad:id,name',
                'mensajeros' => function ($q) {
                    $q->orderBy('id')->with('mensajero:id,name');
                },
                'facturaAsociada:id,numero',
            ])
            ->orderByDesc('diligencias.id')
            ->get();

        $empresaNombre = Empresa::query()->whereKey($empresaId)->value('name') ?? 'Empresa';
        $alcance = 'Todas las diligencias registradas para esta empresa en el sistema (independiente de la pestaña o filtros de esta pantalla).';

        $fileName = 'diligencias_todas_empresa_'.now()->format('Y-m-d_His').'.xlsx';

        return Excel::download(
            new DiligenciasClienteExport(
                diligencias: $diligencias,
                contextoLista: $alcance,
                empresaNombre: (string) $empresaNombre,
            ),
            $fileName
        );
    }

    public function render()
    {
        return view('livewire.diligencia.diligencia.diligencias', [
            'diligencias'=>$this->generales()
        ]);
    }
}
