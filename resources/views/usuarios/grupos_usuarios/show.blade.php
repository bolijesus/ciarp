@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.usuarios')}}">Usuarios</a></li>
    <li><a href="{{route('grupousuario.index')}}">Grupos de Usuarios</a></li>
    <li class="active"><a>Ver Grupo</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    USUARIOS DEL SISTEMA - GRUPOS DE USUARIOS O ROLES
                </h2>
            </div>
            <div class="body">
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h1 class="card-inside-title">DATOS DEL GRUPO SELECCIONADO</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tbody>
                                <tr class="read">
                                    <td class="contact"><b>Id del Grupo</b></td>
                                    <td class="subject">{{$grupo->id}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Nombre</b></td>
                                    <td class="subject">{{$grupo->nombre}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Descripción</b></td>
                                    <td class="subject">{{$grupo->descripcion}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Cantidad de Usuarios en el Grupo</b></td>
                                    <td class="subject">{{$total}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Creado</b></td>
                                    <td class="subject">{{$grupo->created_at}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Modificado</b></td>
                                    <td class="subject">{{$grupo->updated_at}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="list-group">
                            <a class="list-group-item active">
                                MÓDULOS A LOS QUE TIENE ACCESO EL GRUPO DE USUARIOS 
                            </a>
                            @foreach($grupo->modulos as $modulo)
                            <span class="list-group-item">{{$modulo->nombre}} ==> {{$modulo->descripcion}}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection