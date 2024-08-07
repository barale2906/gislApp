<?php

namespace App\Traits;

use App\Models\Financiera\Banco;
use App\Models\Financiera\Concepto;
use App\Models\Financiera\Librodiario;

trait MovimientosTrait
{
    public function movimi(){
        return Librodiario::with('banco','concepto')
                        ->buscar($this->busqueda)
                        ->fecha($this->filtrocrea)
                        ->banco($this->banco_id)
                        ->concepto($this->concepto_id)
                        ->orderBy($this->ordena, $this->ordenado)
                        ->paginate($this->pages);
    }

    public function saldos(){
        return Librodiario::with('banco')
                            ->saldo()
                            ->orderBy('saldo')
                            ->get();
    }

    public function conceptos(){
        $ids=array();

        $conceptos=Librodiario::select('concepto_id')
                                    ->buscar($this->busqueda)
                                    ->fecha($this->filtrocrea)
                                    ->banco($this->banco_id)
                                    ->groupBy('concepto_id')
                                    ->get();

        foreach ($conceptos as $value) {
            if(in_array($value->concepto_id, $ids)){

            }else{
                array_push($ids, $value->concepto_id);
            }
        }

        return Concepto::whereIn('id',$ids)
                                        ->select('id','concepto')
                                        ->orderBy('concepto', 'ASC')
                                        ->get();
    }

    private function movibancos(){
        $ids=array();

        $conceptos=Librodiario::select('banco_id')
                                    ->groupBy('banco_id')
                                    ->get();

        foreach ($conceptos as $value) {
            if(in_array($value->banco_id, $ids)){

            }else{
                array_push($ids, $value->banco_id);
            }
        }

        return Banco::whereIn('id',$ids)
                                        ->select('id','nombre')
                                        ->orderBy('nombre', 'ASC')
                                        ->get();
    }
}
