<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- search form (Optional) -->
        <form action="{{ url('paciente/listar') }}" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="s_dni" class="form-control" placeholder="(DNI) Buscar Paciente"/>
                <span class="input-group-btn">
                    <button type='submit' id='s_quick' class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <!-- Menu::backend_main() -->
        <ul class="sidebar-menu">
            <li class="header">MENU</li>
            <li>
                <a href="{{ url('/home') }}">
                    <i class='fa fa-home'></i> <span>Inicio</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#"><i class='fa fa-user-md'></i> <span>Médicos</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('/medico/listar') }}"><i class="fa fa-circle-o"></i> Listado</a></li>
                    <li><a href="{{ url('/medico/nuevo') }}"><i class="fa fa-circle-o"></i> Nuevo</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class='fa fa-users'></i> <span>Pacientes</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('/paciente/listar') }}"><i class="fa fa-circle-o"></i> Listado</a></li>
                    <li><a href="{{ url('/paciente/nuevo') }}"><i class="fa fa-circle-o"></i> Nuevo</a></li>
                </ul>
            </li>
            <li class="header">PRACTICAS</li>
            <li class="treeview">
                <a href="#"><i class='fa fa-medkit'></i><span>Análisis</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('/analisis/busqueda') }}"><i class="fa fa-circle-o"></i> Búsqueda</a></li>
                    <li><a href="{{ url('/analisis/nuevo') }}"><i class="fa fa-circle-o"></i> Nuevo</a></li>
                </ul>
            </li>
            @if (Auth::user()->hasRole('administrador'))
            <li class="header">ADMINISTRACION</li>
            <li class="treeview">
                <a href="#"><i class='fa fa-user-secret'></i> <span>Usuarios</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('/admin/usuario/listar') }}"><i class="fa fa-circle-o"></i> Listado</a></li>
                    <li><a href="{{ url('/admin/usuario/nuevo') }}"><i class="fa fa-circle-o"></i> Nuevo</a></li>
                </ul>
            </li>
            @endif
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
