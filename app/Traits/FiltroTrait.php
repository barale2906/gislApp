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
    public $is_inicia=false;
    public $is_termina=false;

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

            case 3:
                $this->text='Buscar lista por nombre, producto o descripción';
                $this->is_inicia=!$this->is_inicia;
                $this->is_termina=!$this->is_termina;
                break;

            case 4:
                    $this->text='Buscar producto por nombre';
                    break;

            case 5:
                $this->text='Buscar por nombre, NIT, numero de factura, nombre de la lista de precios';
                $this->is_inicia=!$this->is_inicia;
                $this->is_termina=!$this->is_termina;
                break;

            case 6:
                $this->text='Buscar diligencia por id, remitente, destinatario, mensajero';
                $this->is_creacion=!$this->is_creacion;
                $this->is_entrega=!$this->is_entrega;
                break;
        }
    }
}
