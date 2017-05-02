@extends('adminlte::layouts.app')

@section('htmlheader_title') Sin Permisos @endsection
@section('contentheader_title') Permisos insuficientes @endsection
@section('contentheader_description') Seguridad @endsection
@section('content_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Escritorio </a></li>
        <li class="active">Seguridad</li>
    </ol>
@endsection


@section('main-content')
    <div class="error-page">
        <h2 class="headline text-red">405</h2>
        <div class="error-content">
            <br>
            <h3><i class="fa fa-warning text-red"></i> Oops! Permisos insuficientes para acceder al recurso.</h3>
            <p>
                Para mas infomación comuniquese con el adminitrador del sistema, mientras tanto es posible volver al <a href='{{ url('/home') }}'>Escritorio</a> de la aplicación.
            </p>
        </div>
    </div><!-- /.error-page -->
@endsection
