<?php

namespace App\Traits;

trait StatusTrait
{
    public $contratostatus=["Inactivo","En Proceso","Activo"];
    public $adicionalestatus=["Inactivo","En Proceso","Activo"];
    public $adicionalesaplica=["Básico Mensual","Básico hora","No Salarial"];
    public $adicionalesbase=["Básico","Básico mas subsidio de transporte"];
    public $inasistenciamotivo=["Cita médica","Cita familiar", "Incapacidad", "Evadido", "Vacaciones", "Capacitación"];
    public $inasistenciajustificada=["Injustificada", "Justificada"];
    public $inasistenciaaplicado=["Sin Aplicar", "Aplicado"];
    public $devengadostatus=['Calculando','Pagado'];
    public $plantastatus=['Inactivo','Activo'];
    public $meses=['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
    public $riesgo=[
                        ["Riesgo I" =>0.522],
                        ["Riesgo II" =>1.044],
                        ["Riesgo III" =>2.436],
                        ["Riesgo IV" =>4.350],
                        ["Riesgo V" =>6.960]
                    ];
    public $afirmacion=["No","Si"];
    public $statusfinalizados=[4,5,6,7,8];
}
