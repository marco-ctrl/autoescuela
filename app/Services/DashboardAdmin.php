<?php

namespace App\Services;

use App\Models\ItComprobantePago;
use App\Models\ItEstudiante;
use App\Models\ItCuota;
use App\Models\ItDocente;

class DashboardAdmin {
    
    private function getCantidadEstudiantes() {
        return ItEstudiante::count();
    }

    private function getTotalIngresosDia(){
        return ItComprobantePago::whereDate('cp_fecha_cobro', date('Y-m-d'))
            ->where(function($query){
                $query->where('cp_tipo', 1)
                    ->orWhere('cp_tipo', 2);
            })
            ->sum('cp_pago');
    }

    private function getTotalIngresosMes(){
        //return ItCuota::whereMonth('ct_created', date('m'))->sum('ct_importe');
        return ItComprobantePago::whereMonth('cp_fecha_cobro', date('m'))
            ->whereYear('cp_fecha_cobro', date('Y'))
            ->where(function($query){
                $query->where('cp_tipo', 1)
                    ->orWhere('cp_tipo', 2);
            })
            ->sum('cp_pago');
    }

    private function getCantidadEgresosMes(){
        return ItComprobantePago::whereMonth('cp_fecha_cobro', date('m'))
            ->whereYear('cp_fecha_cobro', date('Y'))
            ->where('cp_tipo', 3)
            ->sum('cp_pago');
    }

    public function getData(){
        $cards = [
            [
                'title' => 'Ingresos del Dia',
                'value' => 'Bs. '.$this->getTotalIngresosDia(),
                'icon' => 'fas fa-cash-register',
                'color' => 'success',
            ],
            [
                'title' => 'Ingresos del Mes',
                'value' => 'Bs. '.$this->getTotalIngresosMes(),
                'icon' => 'fas fa-money-bill-wave',
                'color' => 'info',
            ],
            [
                'title' => 'Egresos del Mes',
                'value' => 'Bs.' . $this->getCantidadEgresosMes(),
                'icon' => 'fas fa-money-bill-wave',
                'color' => 'danger',
            ],
            [
                'title' => 'Cantidad Estudiantes',
                'value' => $this->getCantidadEstudiantes(),
                'icon' => 'fas fa-user-graduate',
                'color' => 'warning',
            ],
        ];

        return $cards;
    }
}