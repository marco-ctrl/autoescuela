<?php

namespace App\Services;

use App\Models\ItEstudiante;
use App\Models\ItCuota;
use App\Models\ItDocente;

class DashboardAdmin {
    
    private function getCantidadEstudiantes() {
        return ItEstudiante::count();
    }

    private function getTotalIngresosDia(){
        return ItCuota::whereDate('ct_created', date('Y-m-d'))->sum('ct_importe');
    }

    private function getTotalIngresosMes(){
        return ItCuota::whereMonth('ct_created', date('m'))->sum('ct_importe');
    }

    private function getCantidadDocentes(){
        return ItDocente::count();
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
                'title' => 'Cantidad Estudiantes',
                'value' => $this->getCantidadEstudiantes(),
                'icon' => 'fas fa-user-graduate',
                'color' => 'warning',
            ],
            [
                'title' => 'Cantidad Docentes',
                'value' => $this->getCantidadDocentes(),
                'icon' => 'fas fa-chalkboard-teacher',
                'color' => 'danger',
            ]
        ];

        return $cards;
    }
}