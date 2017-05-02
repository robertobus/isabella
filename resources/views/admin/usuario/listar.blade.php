@extends('adminlte::layouts.app')

@section('htmlheader_title') Administracion - Usuarios - Listado @endsection
@section('contentheader_title') Listado @endsection
@section('contentheader_description') Usuarios @endsection
@section('content_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Escritorio </a></li>
        <li><a href="{{ url('/admin/usuario/listado') }}"> Administración </a></li>
        <li class="active">Usuarios</li>
    </ol>
@endsection

@section('styles')
    @parent
        <!-- Datatables -->
    <link href="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('adminlte/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('adminlte/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css') }}" rel="stylesheet">
    <!-- PNotify -->
    <link href="{{ asset('plugins/pnotify/dist/pnotify.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/pnotify/dist/pnotify.buttons.css') }}" rel="stylesheet">
@endsection

@section('main-content')
    <div class="row">
        <div class="col-md-12">

            <div class="box box-default">
                <div class="box-body">
                    <table id="listado-usuarios" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Perfil</th>
                            <th>Estado</th>
                            <th style="width: 90px;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($usuarios as $usuario)
                            <tr>
                                <td>{{ $usuario->name }}</td>
                                <td>{{ $usuario->email  }}</td>
                                <td>{{ $usuario->getRole()->name }}</td>
                                <td>
                                    @if ($usuario->status)
                                        <div style="color: #00e765;">
                                            <span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span>&nbsp;
                                            Activo
                                        </div>
                                    @else
                                        <div style="color: #ff2222;">
                                            <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>&nbsp;
                                            Bloqueado
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ url('admin/usuario/detalle', $usuario->id) }}" class="btn btn-link btn-xs">
                                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>&nbsp;
                                        Editar</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
        <!-- Datatables -->
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js') }}"></script>
    <!-- PNotify -->
    <script src="{{ asset('plugins/pnotify/dist/pnotify.js') }}"></script>
    <script src="{{ asset('plugins/pnotify/dist/pnotify.buttons.js') }}"></script>
    <script src="{{ asset('js/alert-messages.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#listado-usuarios').DataTable({
                "language": { url: "{{ asset('/plugins/datatables/i18n/Spanish.json') }}" },
            });

            @if($errors->hasBag('errors'))
                alertMessages('error', 'Error!', '{{ $errors->getBag('errors')->first() }}').open();
            @endif
            @if($errors->hasBag('success'))
                alertMessages('success', 'Exito!', '{{ $errors->getBag('success')->first() }}').open();
            @endif

        });
    </script>

@endsection
