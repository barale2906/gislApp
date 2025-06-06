<?php

namespace App\Traits;

trait FiltroTrait
{
    public $text;
    public $is_filtro=false;
    public $is_creacion=false;
    public $is_banco=false;
    public $is_entrega=false;
    public $is_ubicaenvia=false;
    public $is_ubicarecibe=false;
    public $is_inicia=false;
    public $is_termina=false;
    public $is_crear=true;
    public $is_asignados=false;
    public $is_conceptos=false;

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

            case 7:
                $this->text='Buscar diligencia por id, remitente, destinatario, mensajero';
                $this->is_creacion=!$this->is_creacion;
                $this->is_crear=!$this->is_crear;
                $this->is_asignados=!$this->is_asignados;
                break;

            case 8:
                $this->text='Buscar diligencia por id, remitente, destinatario, mensajero';
                $this->is_crear=!$this->is_crear;
                $this->is_creacion=!$this->is_creacion;
                break;

            case 9:
                $this->text='Buscar cuentas';
                break;

            case 10:
                $this->text='Buscar conceptos';
                break;

            case 11:
                $this->text='Buscar Comentario de Movimientos';
                $this->is_creacion=!$this->is_creacion;
                $this->is_conceptos=!$this->is_conceptos;
                $this->is_banco=!$this->is_banco;
                break;

            case 12:
                $this->text='Buscar carteras por nombre cliente o NIT';
                break;

            case 13:
                $this->text='Buscar contrato';
                break;

            case 14:
                $this->text='Buscar cargos adicionales';
                break;

            case 15:
                $this->text='Buscar salarios';
                break;

            case 16:
                $this->text='Buscar Empleado o aprobador';
                break;

            case 17:
                $this->text='Buscar empleado';
                break;

            case 18:
                $this->text='Buscar historial de empleado.';
                break;
        }
    }
}
