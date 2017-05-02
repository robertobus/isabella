@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('styles')
@parent
	<!-- PNotify -->
	<link href="{{ asset('plugins/pnotify/dist/pnotify.css') }}" rel="stylesheet">
	<link href="{{ asset('plugins/pnotify/dist/pnotify.buttons.css') }}" rel="stylesheet">
	<!-- Ion Icons -->
	<link href="{{ asset('css/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
@endsection

@section('main-content')
	<div class="container-fluid spark-screen">
		<div class="row">
            @if (Auth::user()->hasRole('administrador'))
			<div class="col-md-3">
				<div class="small-box bg-light-blue-gradient">
					<div class="inner">
						<h3>{{ $cantidad_usuarios }}</h3>
						<p>Usuarios</p>
					</div>
					<div class="icon">
						<i class="ion ion-android-person-add"></i>
					</div>
					<a href="{{ url('admin/usuario/listar') }}" class="small-box-footer">
						Ir a Usuarios <i class="fa fa-arrow-circle-right"></i>
					</a>
				</div>
			</div>
            @endif
			<div class="col-md-3">
				<div class="small-box bg-green-gradient">
					<div class="inner">
						<h3>{{ $cantidad_pacientes }}</h3>
						<p>Pacientes</p>
					</div>
					<div class="icon">
						<i class="ion ion-person-add"></i>
					</div>
					<a href="{{ url('paciente/listar') }}" class="small-box-footer">
						Ir a Pacientes <i class="fa fa-arrow-circle-right"></i>
					</a>

				</div>
			</div>
			<div class="col-md-3">
				<div class="small-box bg-red-gradient">
					<div class="inner">
						<h3>{{ $cantidad_analisis }}</h3>
						<p>Analisis</p>
					</div>
					<div class="icon">
						<i class="fa fa-medkit"></i>
					</div>
					<a href="{{ url('analisis/busqueda') }}" class="small-box-footer">
						Ir a Analisis <i class="fa fa-arrow-circle-right"></i>
					</a>
				</div>
			</div>
            <div class="col-md-3">
                    <div class="small-box bg-yellow-gradient">
                        <div class="inner">
                            <h3>{{ $cantidad_medicos }}</h3>
                            <p>Médicos</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-user-md"></i>
                        </div>
                        <a href="{{ url('medico/listar') }}" class="small-box-footer">
                            Ir a Médicos <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
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
