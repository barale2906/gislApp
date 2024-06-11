<?php

namespace App\Traits;

trait FiltroTrait
{
    public $text;
    public $is_filtro=false;
    public $is_creacion=false;
    public $is_entrega=false;
    public $is_ubicaenvia=false;
    public $is_ubicarecibe=false;

    public function filtroMostrar(){
        $this->is_filtro=!$this->is_filtro;
    }


    public function claseFiltro($id){
        switch ($id) {
            case 1:
                $this->text='Buscar diligencia por id, remitente, destinatario';
                $this->is_creacion=!$this->is_creacion;
                $this->is_entrega=!$this->is_entrega;
                break;

            case 2:
                $this->text='Buscar empresa por NIT, nombre';
                break;
        }
    }
}
