<?php

namespace App\Traits;

trait StatusTrait
{
    public $contratostatus=["Inactivo","En Proceso","Activo"];
    public $adicionalestatus=["Inactivo","En Proceso","Activo"];
    public $adicionalesaplica=["Básico Mensual","Básico hora"];
    public $adicionalesbase=["Básico","Básico mas subsidio de transporte"];
    public $inasistenciamotivo=["Cita médica","Cita familiar", "Incapacidad", "Evadido", "Vacaciones", "Capacitación"];
    public $inasistenciajustificada=["Injustificada", "Justificada"];
    public $inasistenciaaplicado=["Sin Aplicar", "Aplicado"];
    public $devengadostatus=['Calculando','Pagado'];
}
