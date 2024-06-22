<?php

namespace Src\manager\caja\application;

use Src\manager\caja\infrastructure\repositories\EgresosRepository;

class StoreEgresosService
{
    protected $egresosRepository;

    // El repositorio de ingresos se inyecta automáticamente por el contenedor de servicios
    public function __construct(EgresosRepository $egresosRepository)
    {
        $this->egresosRepository = $egresosRepository;
    }

    public function run(array $data)
    {
        $egreso = $this->egresosRepository->store($data);

        return $egreso;
    }
}