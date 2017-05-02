@extends('adminlte::layouts.app')

@section('htmlheader_title') Administración - Usuarios - {{ $titulo }} @endsection
@section('contentheader_title') {{ $titulo }} @endsection
@section('contentheader_description') Usuario @endsection
@section('content_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Escritorio </a></li>
        <li><a href="{{ url('/admin/usuario/listado') }}"> Administración </a></li>
        <li class="active">Usuario</li>
    </ol>
@endsection

@section('styles')
    @parent
    <!-- PNotify -->
    <link href="{{ asset('plugins/pnotify/dist/pnotify.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/pnotify/dist/pnotify.buttons.css') }}" rel="stylesheet">
@endsection

@section('main-content')
    <div class="row">
        <div class="col-md-12">

            <div class="box box-default">
                @php $action = $usuario ? 'actualizar' : 'guardar' @endphp
                {!! Form::open(array('method' => 'post', 'url' => url("admin/usuario/$action"))) !!}
                <div class="box-body">
                    {!! Form::token() !!}
                    {!! Form::input('hidden', 'id', $usuario ? $usuario->id : '') !!}
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                {!! Form::label('email', 'Email') !!}
                                @php $disabled = $usuario ? 'disabled' : 'not_disabled' @endphp
                                {!! Form::text('email', $usuario ? $usuario->email : '', array('class' => 'form-control', "{$disabled}" => '')) !!}
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
                                        {{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                                {!! Form::label('status', 'Estado') !!} <br>
                                <div class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-default {{ $usuario ? ($usuario->status == 1 ? 'active' : '') : '' }}">
                                        <span style="color: #00a65a;" class="glyphicon glyphicon-ok" aria-hidden="true"></span>&nbsp;
                                        <input type="radio" name="status" id="status" autocomplete="off" checked value="1"> Activo
                                    </label>
                                    <label class="btn btn-default {{ $usuario ? ($usuario->status == 0 ? 'active' : '') : 'active' }}">
                                        <span style="color: #c9302c;" class="glyphicon glyphicon-remove" aria-hidden="true"></span>&nbsp;
                                        <input type="radio" name="status" id="status" autocomplete="off" value="0"> Bloqueado
                                    </label>
                                </div>
                                @if ($errors->has('status'))
                                    <span class="help-block">
                                        <span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
                                        {{ $errors->first('status') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                {!! Form::label('name', 'Nombre') !!}
                                {!! Form::text('name', $usuario ? $usuario->name : '', array('class' => 'form-control')) !!}
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
                                        {{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                        @if(!$usuario)
                        <div class="col-lg-5">
                            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                {!! Form::label('password', 'Contraseña') !!}
                                {!! Form::password('password', array('class' => 'form-control')) !!}
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
                                        {{ $errors->first('password') }}</span>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="form-group {{ $errors->has('role') ? 'has-error' : '' }}">
                                {!! Form::label('role', 'Perfil') !!}
                                {!! Form::select('role', $roles, $usuario ? ($usuario->getRole() ? $usuario->getRole()->id : '') : '', ['class' => 'form-control']) !!}
                                @if ($errors->has('role'))
                                    <span class="help-block">
                                        <span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
                                        {{ $errors->first('role') }}</span>
                                @endif
                            </div>
                        </div>
                        @if(!$usuario)
                        <div class="col-lg-5">
                            <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                                {!! Form::label('password_confirmation', 'Confirmar Contraseña') !!}
                                {!! Form::password('password_confirmation', array('class' => 'form-control')) !!}
                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
                                        {{ $errors->first('password_confirmation') }}</span>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="row">

                    </div>
                </div>
                <div class="box-footer">
                    @if (!$usuario)
                        {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
                    @else
                        {!! Form::submit('Actualizar', ['class' => 'btn btn-warning']) !!}
                    @endif
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
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
