@extends('layouts.admin')
@section('content')
<div class="col-md-12">
    <div class="alert bg-blue-grey alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        Bienvenido <strong>{{Auth::user()->nombres . ' ' . Auth::user()->apellidos}}</strong> al Sitio Oficial del Comite Interno de Asignación y Reconocimiento de Puntaje CIARP de la Universidad Popular del Cesar.
    </div>
</div>
<div class="col-md-12">
    <div class="row">
        @if(session()->exists('MOD_USUARIOS'))
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-light-green hover-zoom-effect hover-expand-effect">
                <div class="icon">
                    <a href="{{route('admin.usuarios')}}"><i class="material-icons">person</i></a>
                </div>
                <div class="content">
                    <div class="text">USUARIOS</div>
                    <div class="number">CIARP</div>
                </div>
            </div>
        </div>
        @endif
        @if(session()->exists('MOD_SOLICITUD'))
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-orange hover-zoom-effect hover-expand-effect">
                <div class="icon">
                    <a href="{{route('admin.solicitud')}}"><i class="material-icons">view_list</i></a>
                </div>
                <div class="content">
                    <div class="text">SOLICITUDES</div>
                    <div class="number">CIARP</div>
                </div>
            </div>
        </div>
        @endif
        @if(session()->exists('MOD_PQR'))
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box hover-zoom-effect hover-expand-effect" style="background-color: #2cc54e">
                <div class="icon">
                    <a href="{{route('admin.pqr')}}"><i class="material-icons">forum</i></a>
                </div>
                <div class="content">
                    <div class="text" style="color: #ffffff">PQR</div>
                    <div class="number" style="color: #ffffff">CIARP</div>
                </div>
            </div>
        </div>
        @endif
        @if(session()->exists('MOD_REPORTE'))
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-cyan hover-zoom-effect hover-expand-effect">
                <div class="icon">
                    <a href="{{route('admin.reporte')}}"><i class="material-icons">assessment</i></a>
                </div>
                <div class="content">
                    <div class="text">REPORTES</div>
                    <div class="number">CIARP</div>
                </div>
            </div>
        </div>
        @endif
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-red hover-zoom-effect hover-expand-effect">
                <div class="icon">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="material-icons">exit_to_app</i></a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
                <div class="content">
                    <div class="text">SALIR</div>
                    <div class="number">CIARP</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
