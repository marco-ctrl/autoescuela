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
        <a class="nav-link" href="{{ route('docente.home')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Inicio</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Modulos
    </div>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('docente.asistencia')}}">
            <i class="fas fa-list"></i>
            <span> Asistencia</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAdministracion"
            aria-expanded="true" aria-controls="collapseAdministracion">
            <i class="fas fa-archive"></i>
            <span>Reportes</span>
        </a>
        <div id="collapseAdministracion" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('docente.reporte-general') }}"><i class="far fa-file-pdf"></i> Reporte General</a>
                <a class="collapse-item" href="{{ route('docente.reporte-asistencia') }}"><i class="far fa-file-pdf"></i> Reporte Asistencia</a>
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
