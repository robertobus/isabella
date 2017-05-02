@extends('adminlte::layouts.app')

@section('htmlheader_title') Prácticas - Análisis - {{ $titulo }} @endsection
@section('contentheader_title') {{ $titulo }} @endsection
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
    <!-- Select2 -->
    <link href="{{ asset('adminlte/plugins/select2/select2.min.css') }}" rel="stylesheet">
    <!-- Datepicker -->
    <link href="{{ asset('adminlte/plugins/datepicker/datepicker3.css') }}" rel="stylesheet">
    <!-- PNotify -->
    <link href="{{ asset('plugins/pnotify/dist/pnotify.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/pnotify/dist/pnotify.buttons.css') }}" rel="stylesheet">
    <!-- Custom Styles -->
    <link href="{{ asset('css/customs-styles.css') }}" rel="stylesheet">
@endsection

@section('main-content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-default">
                {!! Form::open(array('method' => 'post', 'url' => url("analisis/actualizar", $analisis->id))) !!}
                <div class="box-header with-border">
                    <a href="{{ url('analisis/busqueda') }}" class="btn btn-default btn-md">
                        <span class="fa fa-search-plus" aria-hidden="true"></span>&nbsp;
                        Búsqueda de Análisis</a>
                    <a href="{{ url('analisis/nuevo') }}" class="btn btn-default btn-md">
                        <span class="fa fa-medkit" aria-hidden="true"></span>&nbsp;
                        Nuevo Análisis</a>
                </div>
                <div class="box-body">
                    {!! Form::token() !!}
                            <!-- col left -->
                    <div class="col-md-6" style="border-right: 1px solid silver;">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="form-group {{ $errors->has('paciente_id') ? 'has-error' : '' }}">
                                    {!! Form::label('paciente_id', 'Paciente') !!}
                                    {!! Form::select('paciente_id', $pacientes, $analisis->paciente_id, ['class' => 'form-control select2']) !!}
                                    @if ($errors->has('paciente_id'))
                                        <span class="help-block">
                                            <span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
                                            {{ $errors->first('paciente_id') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group {{ $errors->has('fecha') ? 'has-error' : '' }}">
                                    {!! Form::label('fecha', 'Fecha') !!}
                                    <div class="input-group date">
                                        @php $fecha = \Carbon\Carbon::createFromFormat('Y-m-d', $analisis->fecha); @endphp
                                        {!! Form::text('fecha', $fecha->format('d/m/Y'), array('class' => 'form-control datepicker')) !!}
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </div>
                                    </div>
                                    @if ($errors->has('fecha'))
                                        <span class="help-block">
                                            <span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
                                            {{ $errors->first('fecha') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="form-group {{ $errors->has('medico_id') ? 'has-error' : '' }}">
                                    {!! Form::label('medico_id', 'Médico') !!}
                                    {!! Form::select('medico_id', $medicos, $analisis->medico_id, ['class' => 'form-control select2']) !!}
                                    @if ($errors->has('medico_id'))
                                        <span class="help-block">
                                            <span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
                                            {{ $errors->first('medico_id') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group {{ $errors->has('obra_social_id') ? 'has-error' : '' }}">
                                    {!! Form::label('obra_social_id', 'Obra Social') !!}
                                    {!! Form::select('obra_social_id', $obras_sociales, $analisis->obra_social_id, ['class' => 'form-control']) !!}
                                    @if ($errors->has('obra_social_id'))
                                        <span class="help-block">
                                            <span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
                                            {{ $errors->first('obra_social_id') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group {{ $errors->has('diagnostico') ? 'has-error' : '' }}">
                                    {!! Form::label('diagnostico', 'Diagnostico') !!}
                                    {!! Form::text('diagnostico', $analisis->diagnostico, array('class' => 'form-control')) !!}
                                    @if ($errors->has('diagnostico'))
                                        <span class="help-block">
                                            <span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
                                            {{ $errors->first('diagnostico') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- col rigth -->
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group {{ $errors->has('grupo') ? 'has-error' : '' }}">
                                    {!! Form::label('grupo', 'Grupo AB0') !!}
                                    {!! Form::select('grupo', ['' => 'Seleccione', 'A' => 'A', 'B' => 'B', 'AB' => 'AB', '0' => '0'], $analisis->grupo, ['class' => 'form-control select_custom_highlight_red']) !!}
                                    @if ($errors->has('grupo'))
                                        <span class="help-block">
                                            <span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
                                            {{ $errors->first('grupo') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group {{ $errors->has('factor') ? 'has-error' : '' }}">
                                    {!! Form::label('factor', 'Factor RH') !!}
                                    {!! Form::select('factor', $options_pn, $analisis->factor, ['class' => 'form-control select_custom_highlight_red']) !!}
                                    @if ($errors->has('factor'))
                                        <span class="help-block">
                                            <span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
                                            {{ $errors->first('factor') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group {{ $errors->has('pci') ? 'has-error' : '' }}">
                                    {!! Form::label('pci', 'PCI') !!}
                                    {!! Form::select('pci', $options_pn, $analisis->pci, ['class' => 'form-control select_custom_highlight_red']) !!}
                                    @if ($errors->has('pci'))
                                        <span class="help-block">
                                            <span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
                                            {{ $errors->first('pci') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group {{ $errors->has('pcd') ? 'has-error' : '' }}">
                                    {!! Form::label('pcd', 'PCD') !!}
                                    {!! Form::select('pcd', $options_pn, $analisis->pcd, ['class' => 'form-control select_custom_highlight_red']) !!}
                                    @if ($errors->has('pcd'))
                                        <span class="help-block">
                                            <span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
                                            {{ $errors->first('pcd') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group {{ $errors->has('ppt') ? 'has-error' : '' }}">
                                    {!! Form::label('ppt', 'PPT') !!}
                                    {!! Form::select('ppt', $options_pn, $analisis->ppt, ['class' => 'form-control select_custom_highlight_red']) !!}
                                    @if ($errors->has('ppt'))
                                        <span class="help-block">
                                            <span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
                                            {{ $errors->first('ppt') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group {{ $errors->has('observaciones') ? 'has-error' : '' }}">
                                    {!! Form::label('observaciones', 'Observaciones') !!}
                                    {!! Form::textarea('observaciones', $analisis->observaciones, array('class' => 'form-control', 'rows' => 3)) !!}
                                    @if ($errors->has('observaciones'))
                                        <span class="help-block">
                                            <span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
                                            {{ $errors->first('observaciones') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    {!!  Form::button('<span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;Actualizar', ['class'=>'btn btn-primary', 'type'=>'submit']) !!}
                    <a href="{{ url('analisis/export', $analisis->id) }}" target="_blank" class="btn btn-danger btn-md pull-right">
                        <span class="fa fa-file-pdf-o" aria-hidden="true"></span>&nbsp;
                        Imprimir</a>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    @endsection

    @section('scripts')
    @parent
            <!-- Select2 -->
    <script src="{{ asset('adminlte/plugins/select2/select2.full.min.js') }}"></script>
    <!-- Datepicker -->
    <script src="{{ asset('adminlte/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datepicker/locales/bootstrap-datepicker.es.js') }}"></script>
    <!-- PNotify -->
    <script src="{{ asset('plugins/pnotify/dist/pnotify.js') }}"></script>
    <script src="{{ asset('plugins/pnotify/dist/pnotify.buttons.js') }}"></script>
    <script src="{{ asset('js/alert-messages.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function(){

            $('.select2').select2();

            $('.datepicker').datepicker({
                language: 'es',
                format: 'dd/mm/yyyy',
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
