@extends('adminlte::layouts.app')

@section('htmlheader_title') Administración - Pacientes - {{ $titulo }} @endsection
@section('contentheader_title') {{ $titulo }} @endsection
@section('contentheader_description') Paciente @endsection
@section('content_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Escritorio </a></li>
        <li><a href="{{ url('/admin/usuario/listado') }}"> Administración </a></li>
        <li class="active">Paciente</li>
    </ol>
@endsection

@section('styles')
    @parent
    <!-- Datepicker -->
    <link href="{{ asset('adminlte/plugins/datepicker/datepicker3.css') }}" rel="stylesheet">
    <!-- PNotify -->
    <link href="{{ asset('plugins/pnotify/dist/pnotify.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/pnotify/dist/pnotify.buttons.css') }}" rel="stylesheet">
@endsection

@section('main-content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-default">
                {!! Form::open(array('method' => 'post', 'url' => url("paciente/guardar"))) !!}
                <div class="box-header with-border">
                    <a href="{{ url('paciente/listar') }}" class="btn btn-default btn-md">
                        <span class="fa fa-users" aria-hidden="true"></span>&nbsp;
                        Listado Pacientes</a>
                </div>
                <div class="box-body">
                    {!! Form::token() !!}
                    <!-- col left -->
                    <div class="col-md-6" style="border-right: 1px solid silver;">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group {{ $errors->has('dni') ? 'has-error' : '' }}">
                                    {!! Form::label('dni', 'Documento') !!}
                                    {!! Form::text('dni', '', array('class' => 'form-control')) !!}
                                    @if ($errors->has('dni'))
                                        <span class="help-block">
                                            <span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
                                            {{ $errors->first('dni') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group {{ $errors->has('nacimiento') ? 'has-error' : '' }}">
                                    {!! Form::label('nacimiento', 'Nacimiento') !!}
                                    <div class="input-group date">
                                        {!! Form::text('nacimiento', '', array('class' => 'form-control datepicker')) !!}
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </div>
                                    </div>
                                    @if ($errors->has('nacimiento'))
                                        <span class="help-block">
                                            <span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
                                            {{ $errors->first('nacimiento') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group {{ $errors->has('apellido') ? 'has-error' : '' }}">
                                    {!! Form::label('apellido', 'Apellido') !!}
                                    {!! Form::text('apellido', '', array('class' => 'form-control')) !!}
                                    @if ($errors->has('apellido'))
                                        <span class="help-block">
                                            <span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
                                            {{ $errors->first('apellido') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group {{ $errors->has('nombre') ? 'has-error' : '' }}">
                                    {!! Form::label('nombre', 'Nombre') !!}
                                    {!! Form::text('nombre', '', array('class' => 'form-control')) !!}
                                    @if ($errors->has('nombre'))
                                        <span class="help-block">
                                            <span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
                                            {{ $errors->first('nombre') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group {{ $errors->has('observaciones') ? 'has-error' : '' }}">
                                    {!! Form::label('observaciones', 'Observaciones') !!}
                                    {!! Form::textarea('observaciones', '', array('class' => 'form-control', 'rows' => 3)) !!}
                                    @if ($errors->has('observaciones'))
                                        <span class="help-block">
                                            <span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
                                            {{ $errors->first('observaciones') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- col rigth -->
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group {{ $errors->has('ciudad_id') ? 'has-error' : '' }}">
                                    {!! Form::label('ciudad_id', 'Ciudad') !!}
                                    {!! Form::select('ciudad_id', $ciudades, '', ['class' => 'form-control']) !!}
                                    @if ($errors->has('ciudad_id'))
                                        <span class="help-block">
                                            <span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
                                            {{ $errors->first('ciudad_id') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group {{ $errors->has('provincia_id') ? 'has-error' : '' }}">
                                    {!! Form::label('provincia_id', 'Provincia') !!}
                                    {!! Form::select('provincia_id', $provincias, '', ['class' => 'form-control']) !!}
                                    @if ($errors->has('provincia_id'))
                                        <span class="help-block">
                                            <span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
                                            {{ $errors->first('provincia_id') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group {{ $errors->has('direccion') ? 'has-error' : '' }}">
                                    {!! Form::label('direccion', 'Dirección') !!}
                                    <div class="input-group">
                                        {!! Form::text('direccion', '', array('class' => 'form-control')) !!}
                                        <div class="input-group-addon">
                                            <span class="fa fa-fw fa-map-marker"></span>
                                        </div>
                                    </div>
                                    @if ($errors->has('direccion'))
                                        <span class="help-block">
                                            <span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
                                            {{ $errors->first('direccion') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group {{ $errors->has('telefono') ? 'has-error' : '' }}">
                                    {!! Form::label('telefono', 'Telefono') !!}
                                    <div class="input-group">
                                        {!! Form::text('telefono', '', array('class' => 'form-control')) !!}
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-phone"></span>
                                        </div>
                                    </div>
                                    @if ($errors->has('telefono'))
                                        <span class="help-block">
                                            <span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
                                            {{ $errors->first('telefono') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                    {!! Form::label('email', 'Email') !!}
                                    <div class="input-group">
                                        {!! Form::text('email', '', array('class' => 'form-control')) !!}
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-envelope"></span>
                                        </div>
                                    </div>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
                                            {{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    {!!  Form::button('<span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;Guardar', ['class'=>'btn btn-primary', 'type'=>'submit']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <!-- Datepicker -->
    <script src="{{ asset('adminlte/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datepicker/locales/bootstrap-datepicker.es.js') }}"></script>
    <!-- PNotify -->
    <script src="{{ asset('plugins/pnotify/dist/pnotify.js') }}"></script>
    <script src="{{ asset('plugins/pnotify/dist/pnotify.buttons.js') }}"></script>
    <script src="{{ asset('js/alert-messages.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function(){

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
