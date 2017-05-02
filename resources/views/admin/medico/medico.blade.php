@extends('adminlte::layouts.app')

@section('htmlheader_title') Administración - Médicos - {{ $titulo }} @endsection
@section('contentheader_title') {{ $titulo }} @endsection
@section('contentheader_description') Médico @endsection
@section('content_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Escritorio </a></li>
        <li><a href="{{ url('/medico/listado') }}"> Administración </a></li>
        <li class="active">Médico</li>
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
                {!! Form::open(array('method' => 'post', 'url' => url("medico/guardar"))) !!}
                <div class="box-header with-border">
                    <a href="{{ url('medico/listar') }}" class="btn btn-default btn-md">
                        <span class="fa fa-user-md" aria-hidden="true"></span>&nbsp;
                        Listado Médicos</a>
                </div>
                <div class="box-body">
                    {!! Form::token() !!}
                    <!-- col left -->
                    <div class="col-md-6" style="border-right: 1px solid silver;">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group {{ $errors->has('matricula') ? 'has-error' : '' }}">
                                    {!! Form::label('matricula', 'Matricula') !!}
                                    {!! Form::text('matricula', '', array('class' => 'form-control')) !!}
                                    @if ($errors->has('matricula'))
                                        <span class="help-block">
                                            <span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
                                            {{ $errors->first('matricula') }}</span>
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
                    </div>
                    <!-- col rigth -->
                    <div class="col-md-6">
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

            @if(Session::has('msg_error'))
                alertMessages('error', 'Error!', '{{ Session::get('msg_error') }}').open();
            @endif
            @if(Session::has('msg_success'))
                alertMessages('success', 'Exito!', '{{ Session::get('msg_success') }}').open();
            @endif

        });
    </script>

@endsection
