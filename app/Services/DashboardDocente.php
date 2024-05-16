<?php

namespace App\Services;

use App\Models\ItDocente;
use App\Models\ItHorarioMatricula;

class DashboardDocente {
    
    private function getTotalClasesDia(int $do_codigo){
        return ItHorarioMatricula::whereDate('hm_fecha_inicio', date('Y-m-d'))
        ->where('do_codigo', $do_codigo)
        ->count();
    }

    private function getTotalClasesMes(int $do_codigo){
        return ItHorarioMatricula::whereMonth('hm_fecha_inicio', date('m'))
        ->where('do_codigo', $do_codigo)
        ->count();
    }
    
    private function getTotalFaltaEstudiantes(int $do_codigo){
        return ItHorarioMatricula::whereDate('hm_fecha_inicio', date('Y-m-d'))
        ->where('do_codigo', $do_codigo)
        ->where('hm_asistencia', 0)
        ->count();
    }

    private function getTotalAsistenciaEstudiantes(int $do_codigo){
        return ItHorarioMatricula::whereDate('hm_fecha_inicio', date('Y-m-d'))
        ->where('do_codigo', $do_codigo)
        ->where('hm_asistencia', 1)
        ->count();
    }

    public function getData(int $codigo){
        $cards = [
            [
                'title' => 'Clases Del Dia',
                'value' => $this->getTotalClasesDia($codigo),
                'icon' => 'fas fa-user-graduate',
                'color' => 'warning',
            ],
            [
                'title' => 'Clases Del Mes',
                'value' => $this->getTotalClasesMes($codigo),
                'icon' => 'fas fa-university',
                'color' => 'info',
            ],
            [
                'title' => 'Falta Estudiantes',
                'value' => $this->getTotalFaltaEstudiantes($codigo),
                'icon' => 'far fa-window-close',
                'color' => 'danger',
            ],
            [
                'title' => 'Asistencia Estudiantes',
                'value' => $this->getTotalAsistenciaEstudiantes($codigo),
                'icon' => 'fas fa-check-circle',
                'color' => 'success',
            ],
        ];

        return $cards;
    }
}