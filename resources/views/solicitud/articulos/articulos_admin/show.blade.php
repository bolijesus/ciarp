@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.solicitud')}}">Solicitud</a></li>
    <li><a href="{{route('admin.solicitud')}}">Artículos Científicos</a></li>
    <li class="active"><a href="{{route('articulo.indexadmin')}}">Artículos</a></li>
    <li class="active"><a>Ver Artículos</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    GESTIÓN DE ARTÍCULOS CIENTÍFICOS - VER UN ARTÍCULO
                </h2>
            </div>
            <div class="body">
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h1 class="card-inside-title">DATOS DEL ARTÍCULO SELECCIONADO</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tbody>
                                <tr class="read">
                                    <td class="contact"><b>Identificaión</b></td>
                                    <td class="subject">{{$docente->tipodoc." - ".$docente->numero_documento}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Nombre</b></td>
                                    <td class="subject">{{$nombre}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Dedicación</b></td>
                                    <td class="subject">{{$docente->dedicacion}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>E-mail</b></td>
                                    <td class="subject">{{$docente->correo}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Celular</b></td>
                                    <td class="subject">{{$docente->celular}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Facultad</b></td>
                                    <td class="subject">{{$docente->departamentof->facultad->nombre}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Categoria</b></td>
                                    <td class="subject">{{$docente->categoria->nombre}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Grupo de Investigación</b></td>
                                    <td class="subject">{{$solicitud->grupo_investigacion}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Tipo de Solicitud</b></td>
                                    <td class="subject">{{$solicitud->tipo}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Radicado</b></td>
                                    <td class="subject">{{$solicitud->radicado}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Titulo</b></td>
                                    <td class="subject">{{$solicitud->titulo}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Nombre de la Revista</b></td>
                                    <td class="subject">{{$articulo->nombre_revista}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Clasificación</b></td>
                                    <td class="subject">{{$articulo->clasificacion}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Fecha de Publicación</b></td>
                                    <td class="subject">{{$articulo->fechapublicacion}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Evidencia Filiación UPC</b></td>
                                    <td class="subject">{{$articulo->evd_filiacion_upc}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Idioma</b></td>
                                    <td class="subject">{{$articulo->idioma}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Número de Autores</b></td>
                                    <td class="subject">{{$solicitud->num_autores}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Artículo</b></td>
                                    <td><a target="_blank" href="{{asset('docs/articulo/'.$articulo->articulo_pdf)}}">{{$articulo->articulo_pdf}}</a></td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Publindex - Colciencias</b></td>
                                    <td><a target="_blank" href="{{asset('docs/publindex/'.$articulo->publindex)}}">{{$articulo->publindex}}</a></td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>ISSN</b></td>
                                    <td><a target="_blank" href="{{asset('docs/issn/'.$solicitud->issn)}}">{{$solicitud->issn}}</a></td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>CVLAC</b></td>
                                    <td><a target="_blank" href="{{asset('docs/cvlac/'.$solicitud->cvlac)}}">{{$solicitud->cvlac}}</a></td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>GrupLAC</b></td>
                                    <td><a target="_blank" href="{{asset('docs/gruplac/'.$solicitud->gruplac)}}">{{$solicitud->gruplac}}</a></td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Estado</b></td>
                                    <td class="subject">
                                        @if($solicitud->estado == 'EN ESTUDIO')
                                        <label class="label label-info">EN ESTUDIO</label>
                                        @elseif($solicitud->estado == 'EN ESPAERA')
                                        <label class="label label-warning">EN ESPERA</label>
                                        @elseif($solicitud->estado == 'EVALUADA')
                                        <label class="label label-success">EVALUADA</label>
                                        @else
                                        <label class="label label-danger">RECHAZADA</label>
                                        @endif
                                    </td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Puntos Salariales Solicitados</b></td>
                                    <td class="subject">{{$articulo->ps_solicitados}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Bonificaciones Solicitados</b></td>
                                    <td class="subject">{{$articulo->bo_solicitados}}</td>
                                </tr>
                                @if($solicitud->puntos_aproximados !== 0)
                                <tr class="read">
                                    <td class="contact"><b>Puntos Aproximados</b></td>
                                    <td class="subject">{{$solicitud->puntos_aproximados}}</td>
                                </tr>
                                @else
                                <tr class="read">
                                    <td class="contact"><b>Puntos Salariales</b></td>
                                    <td class="subject">{{$solicitud->puntos_ps}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Bonificaciones</b></td>
                                    <td class="subject">{{$solicitud->puntos_bo}}</td>
                                </tr>
                                @endif
                                <tr class="read">
                                    <td class="contact"><b>Creado</b></td>
                                    <td class="subject">{{$articulo->created_at}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Modificado</b></td>
                                    <td class="subject">{{$articulo->updated_at}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection