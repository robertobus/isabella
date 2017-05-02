@extends('adminlte::layouts.app')

@section('htmlheader_title') Administracion - Pacientes - Listado @endsection
@section('contentheader_title') Listado @endsection
@section('contentheader_description') Pacientes @endsection
@section('content_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Escritorio </a></li>
        <li><a href="{{ url('/admin/pacientes/listado') }}"> Administración </a></li>
        <li class="active">Pacientes</li>
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
                <div class="box-header with-border">
                    <a href="{{ url('paciente/nuevo') }}" class="btn btn-default btn-md">
                        <span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;
                        Nuevo Paciente</a>
                </div>
                <div class="box-body">
                    <form id="search-pacientes" class="form-inline" method="get" action="{{ url('paciente/listar') }}">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-addon">Dni</div>
                                        {!! Form::text('s_dni', isset($_search['s_dni']) ? $_search['s_dni'] : '', array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-addon">Apellido</div>
                                        {!! Form::text('s_apellido', isset($_search['s_apellido']) ? $_search['s_apellido'] : '', array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-addon">Nombre</div>
                                        {!! Form::text('s_nombre', isset($_search['s_nombre']) ? $_search['s_nombre'] : '', array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-default btn-sm">
                                    <i class="glyphicon glyphicon-filter"></i>
                                    Buscar</button>
                                @if (isset($_search['s_dni']) || isset($_search['s_apellido']) || isset($_search['s_nombre']))
                                <a href="{{ url('paciente/listar') }}" class="btn btn-danger btn-sm">
                                    <i class="fa fa-ban"></i>
                                    Borrar Filtros</a>
                                @endif
                            </div>
                        </div><br>
                    </form>
                    <table id="listado-pacientes-new" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Documento</th>
                            <th>Apellido</th>
                            <th>Nombre</th>
                            <th>Telefono</th>
                            <th style="width: 90px;"></th>
                        </tr>
                        </thead>
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
            var oTable = $('#listado-pacientes-new').DataTable({
                "language": { url: "{{ asset('/plugins/datatables/i18n/Spanish.json') }}" },
                processing: true, serverSide: true, 'searching': false, stateSave: true,
                ajax: {
                    url: '{!! url('paciente/listardata') !!}',
                    data: function(d){
                        d.s_dni = $('#search-pacientes input[name=s_dni]').val();
                        d.s_apellido = $('#search-pacientes input[name=s_apellido]').val();
                        d.s_nombre = $('#search-pacientes input[name=s_nombre]').val();
                    }
                },
                columns: [
                    { data: 'dni', name: 'dni', orderable: true, type: 'integer' },
                    { data: 'apellido', name: 'apellido', orderable: true, type: 'string' },
                    { data: 'nombre', name: 'nombre', orderable: true, type: 'string' },
                    { data: 'telefono', name: 'telefono', orderable: true, type: 'string' },
                    { data: 'opciones', name: 'opciones', orderable: false, searchable: false }
                ]
            });

            /*$('#search-pacientes').on('submit', function(e) {
                oTable.draw();
                e.preventDefault();
            });*/

            @if(Session::has('msg_error'))
                alertMessages('error', 'Error!', '{{ Session::get('msg_error') }}').open();
            @endif
            @if(Session::has('msg_success'))
                alertMessages('success', 'Exito!', '{{ Session::get('msg_success') }}').open();
            @endif

        });
    </script>

@endsection
