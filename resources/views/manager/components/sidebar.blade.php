<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon rotate-n-15">
            <!--<i class="fas fa-laugh-wink"></i>-->
            <img src="{{asset('img/logo.png')}}" style="width: 70px;
                    height: auto;"/>
        </div>
        <div class="sidebar-brand-text mx-3">CCTP - AROMA CENTRAL</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('manager.home')}}">
            <i class="fas fa-chart-line"></i>
            <span>Inicio</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Modulos
    </div>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMatricula"
            aria-expanded="true" aria-controls="collapseMatricula">
            <i class="fas fa-school"></i>
            <span>Matricula</span>
        </a>
        <div id="collapseMatricula" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('manager.matriculas.create') }}"><i class="fas fa-edit"></i> Registrar</a>
                <a class="collapse-item" href="{{ route('manager.matriculas.index') }}"><i class="fas fa-list"></i> Matriculados</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseServicio"
            aria-expanded="true" aria-controls="collapseServicio">
            <i class="fas fa-folder-open"></i>
            <span>Servicios</span>
        </a>
        <div id="collapseServicio" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('manager.registro.servicios.index') }}"><i class="fas fa-edit"></i> Servicios Registrados</a>
                <a class="collapse-item" href="{{ route('manager.registro.servicios.create') }}"><i class="fas fa-th-list"></i> servicios</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsemanageristracion"
            aria-expanded="true" aria-controls="collapsemanageristracion">
            <i class="fas fa-toolbox"></i>
            <span>Administracion</span>
        </a>
        <div id="collapsemanageristracion" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('manager.estudiante.index') }}"><i class="fas fa-user-graduate"></i> Estudiante</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCaja"
            aria-expanded="true" aria-controls="collapseCaja">
            <i class="fas fa-cash-register"></i>
            <span>Caja</span>
        </a>
        <div id="collapseCaja" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('manager.caja.pagos.create') }}"><i class="fas fa-hand-holding-usd"></i> Pago Cuotas</a>
                <a class="collapse-item" href="{{ route('manager.caja.pagar-docente.create') }}"><i class="fas fa-file-invoice-dollar"></i> Pagar Docente</a>
                <a class="collapse-item" href="{{ route('manager.caja.ingresos.create') }}"><i class="fas fa-cash-register"></i> Ingresos</a>
                <a class="collapse-item" href="{{ route('manager.caja.egresos') }}"><i class="fas fa-money-bill"></i> Gastos</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReportes"
            aria-expanded="true" aria-controls="collapseReportes">
            <i class="fas fa-folder-open"></i>
            <span>Reportes</span>
        </a>
        <div id="collapseReportes" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('manager.reportes.reporte-general') }}"><i class="fas fa-file-pdf"></i> Reporte General</a>
                <a class="collapse-item" href="{{ route('manager.reportes.resumen-ingresos-egresos') }}"><i class="fas fa-file-pdf"></i> Ingresos Egresos</a>
                <a class="collapse-item" href="{{ route('manager.reportes.cronograma-resumen') }}"><i class="fas fa-file-pdf"></i> Cronograma Resumen</a>
                <a class="collapse-item" href="{{ route('manager.reportes.exportar-comprobante') }}"><i class="fas fa-file-pdf"></i> Exportar Comprobante</a>
                <a class="collapse-item" href="{{ route('manager.reportes.matriculados') }}"><i class="fas fa-file-pdf"></i> Reporte Matriculados</a>
                <a class="collapse-item" href="{{ route('manager.reportes.historial-estudiante') }}"><i class="fas fa-file-pdf"></i> Historial Estudiante</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
