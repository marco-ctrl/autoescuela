<?php

namespace Src\manager\caja\application;

use Src\manager\caja\infrastructure\repositories\IngresosRepository;

class StoreIngresosService
{
    protected $ingresosRepository;

    // El repositorio de ingresos se inyecta automáticamente por el contenedor de servicios
    public function __construct(IngresosRepository $ingresosRepository)
    {
        $this->ingresosRepository = $ingresosRepository;
    }

    public function run(array $data)
    {
        $ingreso = $this->ingresosRepository->store($data);

        return $ingreso;
    }
}