@extends('adminlte::layouts.app')

@section('htmlheader_title') Prácticas - Análisis - Búsqueda @endsection
@section('contentheader_title') Búsqueda @endsection
@section('contentheader_description') Análisis @endsection
@section('content_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Escritorio </a></li>
        <li><a href="#"> Prácticas </a></li>
        <li class="active">Análisis</li>
    </ol>
@endsection

@section('styles')
    @parent
    <!-- Datatables -->
    <link href="{{ asset('plugins/datatables/media/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/datatables/extensions/Responsive/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/datatables/extensions/Scroller/css/scroller.bootstrap.min.css') }}" rel="stylesheet">
    <!-- PNotify -->
    <link href="{{ asset('plugins/pnotify/dist/pnotify.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/pnotify/dist/pnotify.buttons.css') }}" rel="stylesheet">
@endsection

@section('main-content')
    <div class="row">
        <div class="col-md-12">

            <div class="box box-default">
                <div class="box-header with-border">
                    <a href="{{ url('analisis/nuevo') }}" class="btn btn-default btn-md">
                        <span class="fa fa-medkit" aria-hidden="true"></span>&nbsp;
                        Nuevo Analisis</a>
                </div>
                <div class="box-body">
                    <table id="listado-analisis" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>N°</th>
                            <th>Fecha</th>
                            <th>Dni</th>
                            <th>Paciente</th>
                            <th>Médico</th>
                            <th>Obra Social</th>
                            <th style="width: 120px;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($conjAnalisis as $analisis)
                            <tr>
                                <td>{{ str_pad($analisis->id, 10, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ Carbon\Carbon::createFromFormat('Y-m-d', $analisis->fecha)->format('d/m/Y') }}</td>
                                <td>{{ $analisis->paciente->dni }}</td>
                                <td>{{ "{$analisis->paciente->apellido}, {$analisis->paciente->nombre}" }}</td>
                                <td>{{ "{$analisis->medico->apellido}, {$analisis->medico->nombre}" }}</td>
                                <td>{{ $analisis->obraSocial ? $analisis->obraSocial->descripcion : 'No Informa' }}</td>
                                <td>
                                    <a href="{{ url('analisis/detalle', $analisis->id) }}" class="btn btn-link btn-xs">
                                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>&nbsp;
                                        Detalle</a>
                                    <a href="{{ url('analisis/export', $analisis->id) }}" class="btn btn-link btn-xs">
                                        <span class="glyphicon glyphicon-import" aria-hidden="true"></span>&nbsp;
                                        Imprimir</a>
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
    <script src="{{ asset('plugins/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/media/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js') }}"></script>
    <!-- PNotify -->
    <script src="{{ asset('plugins/pnotify/dist/pnotify.js') }}"></script>
    <script src="{{ asset('plugins/pnotify/dist/pnotify.buttons.js') }}"></script>
    <script src="{{ asset('js/alert-messages.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#listado-analisis').DataTable({
                "language": { url: "{{ asset('/plugins/datatables/i18n/Spanish.json') }}" },
            });

            @if(Session::has('msg_error'))
                alertMessages('error', 'Error!', '{{ Session::get('msg_error') }}').open();
            @endif
            @if(Session::has('msg_success'))
                alertMessages('success', 'Exito!', '{{ Session::get('msg_success') }}').open();
            @endif

        });
    </script>

@endsection
