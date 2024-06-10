<?php

namespace App\Livewire\Configuracion\Usuarios;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class UserList extends Component
{
    use WithPagination;

    public $ordena='id';
    public $ordenado='ASC';
    public $pages = 15;

    public $is_modify = true;
    public $is_creating = false;
    public $is_perfil=false;

    public $tipo;
    public $elegido;

    protected $listeners = ['refresh' => '$refresh'];

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
        $this->cancela();
        $this->elegido=$id;
        $this->tipo=$est;

        if($est===3){
            $this->is_modify = !$this->is_modify;
            $this->is_perfil=!$this->is_perfil;
        }else{
            $this->is_modify = !$this->is_modify;
            $this->is_creating = !$this->is_creating;
        }

    }

    //Activar evento
    #[On('cancelando')]
    //resetear variables
    public function cancela(){
        $this->reset(
                        'is_modify',
                        'is_creating',
                        'is_perfil',
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

    private function usuarios(){
        return User::orderBy($this->ordena, $this->ordenado)
                    ->paginate($this->pages);
    }
    public function render()
    {
        return view('livewire.configuracion.usuarios.user-list', [
            'usuarios' => $this->usuarios(),
        ]);
    }
}
