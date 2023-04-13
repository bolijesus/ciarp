@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li class="active"><a href="{{route('admin.usuarios')}}">Usuarios</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    USUARIOS DEL SISTEMA<small>MENÚ</small>
                </h2>
            </div>
            <div class="body">
                <div class="alert bg-green alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong>Detalles: </strong> Agregue usuarios al sistema y administre sus privilegios, gestione los usuarios, configure los grupos de usuarios, así como también los módulos del sistema, entre otras tareas.
                </div>
                <div class="button-demo">
                    @if(session()->exists('PAG_MODULOS'))
                    <a href="{{route('modulo.index')}}" class="btn bg-light-green waves-effect">
                        <div><span>MÓDULOS DEL SISTEMA</span><span class="ink animate"></span></div>
                    </a>  
                    @endif
                    @if(session()->exists('PAG_PAGINAS'))
                    <a href="{{route('pagina.index')}}" class="btn bg-light-green waves-effect">
                        <div><span>PÁGINAS DEL SISTEMA</span><span class="ink animate"></span></div>
                    </a>  
                    @endif
                    @if(session()->exists('PAG_GRUPOS-ROLES'))
                    <a href="{{route('grupousuario.index')}}" class="btn bg-light-green waves-effect">
                        <div><span>GRUPOS O ROLES DE USUARIOS</span><span class="ink animate"></span></div>
                    </a>  
                    @endif
                    @if(session()->exists('PAG_PRIVILEGIOS'))
                    <a href="{{route('grupousuario.privilegios')}}" class="btn bg-light-green waves-effect">
                        <div><span>PRIVILÉGIOS A PÁGINAS</span><span class="ink animate"></span></div>
                    </a>  
                    @endif
                    @if(session()->exists('PAG_USUARIOS'))
                    <a href="{{route('usuario.index')}}" class="btn bg-light-green waves-effect" data-toggle="tooltip" data-placement="top" title="Tenga en cuenta que al cargar gran cantidad de registros puede hacer que el navegador se bloquee y deba esperar a que este cargue todos los registros de la base de datos para continuar la navegación.">
                        <div><span>LISTAR TODOS LOS USUARIOS</span><span class="ink animate"></span></div>
                    </a> 
                    @endif
                    @if(session()->exists('PAG_USUARIO-MANUAL'))
                    <a href="{{route('usuario.create')}}" class="btn bg-light-green waves-effect">
                        <div><span>USUARIO MANUAL</span><span class="ink animate"></span></div>
                    </a> 
                    @endif
                    @if(session()->exists('PAG_AUTOMATICO'))
                    <a class="btn bg-light-green waves-effect" disabled='disabled'>
                        <div><span>USUARIO AUTOMÁTICO</span><span class="ink animate"></span></div>
                    </a> 
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@if(session()->exists('PAG_OPERACIONES-USUARIO'))
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    MODIFICACIÓN Y ELIMINACIÓN DE USUARIOS
                </h2>
            </div>
            <div class="body">
                <div class="row clearfix">
                    {!! Form::open(['route'=>'usuario.operaciones','method'=>'POST','class'=>'form-horizontal form-label-left'])!!}
                    <div class="col-md-12">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <div class="form-line">
                                    {!! Form::text('id',null,['class'=>'form-control','placeholder'=>'Escriba la identificación a consultar','id'=>'id']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            {!! Form::submit('CONSULTAR USUARIO',['class'=>'btn bg-deep-orange waves-effect btn-block']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection