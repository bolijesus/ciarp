@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li class="active"><a href="{{route('admin.reporte')}}">Reportes</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    GESTIÓN DE REPORTES<small>MENÚ</small>
                </h2>
            </div>
            <div class="body">
                <div class="alert bg-green alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong>Detalles: </strong> Genere los diferentes reportes de la productividad académica de los docentes.
                </div>
                <div class="button-demo">
                    @if(session()->exists('PAG_MODULOS'))
                    <a href="{{route('reportes.acta')}}" class="btn bg-light-green waves-effect">
                        <div><span>GENEREAR ACTA</span><span class="ink animate"></span></div>
                    </a>  
                    @endif
                    @if(session()->exists('PAG_PAGINAS'))
                    <a href="{{route('reportes.productividad')}}" class="btn bg-light-green waves-effect">
                        <div><span>REPORTE GENERAL</span><span class="ink animate"></span></div>
                    </a>  
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection