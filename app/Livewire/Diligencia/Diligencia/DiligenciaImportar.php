<?php

namespace App\Livewire\Diligencia\Diligencia;

use App\Imports\DiligenciasImport;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class DiligenciaImportar extends Component
{
    use WithFileUploads;

    public $archivo;

    /**
     * Reglas de validación
     */
    protected $rules = [
        'archivo'    => 'required|mimes:xls,xlsx'
    ];

    public function importar(){

        // validate
        $this->validate();

        Excel::import(new DiligenciasImport, $this->archivo);

        $this->reset('archivo');
        $this->dispatch('alerta', name:'Se importo correctamente el archivo ');

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');


    }


    public function render()
    {
        return view('livewire.diligencia.diligencia.diligencia-importar');
    }
}
