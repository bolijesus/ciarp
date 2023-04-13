@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.solicitud')}}">Solicitud</a></li>
    @if(session()->exists('PAG_SOLICITUD-PONENCIA-DOC'))
    <li><a href="{{route('ponencia.index')}}">Ponencias</a></li>
    @endif
    @if(session()->exists('PAG_SOLICITUD-PONENCIA-ADM'))
    <li><a href="{{route('ponencia.indexadmin')}}">Ponencias</a></li>
    @endif
    <li class="active"><a>Ver Ponencia</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    GESTIÓN DE PONENCIA - VER UNA PONENCIA
                </h2>
            </div>
            <div class="body">
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h1 class="card-inside-title">DATOS DE LA PONENCIA SELECCIONADA</h1>
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
                                    <td class="contact"><b>Tipo de Evento</b></td>
                                    <td class="subject">{{$ponencia->tipo}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Lugar</b></td>
                                    <td class="subject">{{$ponencia->lugar}}</td>
                                </tr><tr class="read">
                                    <td class="contact"><b>Nombre del Evento</b></td>
                                    <td class="subject">{{$ponencia->nombre_evento}}</td>
                                </tr>
                                </tr><tr class="read">
                                    <td class="contact"><b>Fecha del Evento</b></td>
                                    <td class="subject">{{$ponencia->fecha_evento}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>¿Evidencia Crédito a la UPC?</b></td>
                                    <td class="subject">{{$solicitud->evd_cred_upc}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Idioma</b></td>
                                    <td class="subject">{{$ponencia->idioma}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Número de Actores</b></td>
                                    <td class="subject">{{$solicitud->num_autores}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>ISBN</b></td>
                                    <td class="subject">{{$solicitud->isbn}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Memorias</b></td>
                                    <td><a target="_blank" href="{{asset('docs/ponencia/memorias/'.$ponencia->archivo_memorias)}}">{{$ponencia->archivo_memorias}}</a></td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Certificado de Ponente</b></td>
                                    <td><a target="_blank" href="{{asset('docs/ponencia/cert_ponente/'.$ponencia->cert_ponente)}}">{{$ponencia->cert_ponente}}</a></td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>CVLAC</b></td>
                                    <td><a target="_blank" href="{{asset('docs/ponencia/cvlac/'.$solicitud->cvlac)}}">{{$solicitud->cvlac}}</a></td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>GrupLAC</b></td>
                                    <td><a target="_blank" href="{{asset('docs/ponencia/gruplac/'.$solicitud->gruplac)}}">{{$solicitud->gruplac}}</a></td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Estado</b></td>
                                    <td class="subject">
                                        @if($solicitud->estado == 'EN ESTUDIO')
                                        <label class="label label-info">EN ESTUDIO</label>
                                        @elseif($solicitud->estado == 'EN ESPERA')
                                        <label class="label label-warning">EN ESPERA</label>
                                        @elseif($solicitud->estado == 'APROBADA')
                                        <label class="label label-success">APROBADA</label>
                                        @else
                                        <label class="label label-danger">RECHAZADA</label>
                                        @endif
                                    </td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Puntos Salariales Aproximados</b></td>
                                    <td class="subject">{{$solicitud->puntos_aproximados_ps}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Puntos de Bonificación Aproximados</b></td>
                                    <td class="subject">{{$solicitud->puntos_aproximados_bo}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Puntos Salariales Asignados</b></td>
                                    <td class="subject">{{$solicitud->puntos_ps}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Bonificaciones Asignadas</b></td>
                                    <td class="subject">{{$solicitud->puntos_bo}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Creado</b></td>
                                    <td class="subject">{{$ponencia->created_at}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Modificado</b></td>
                                    <td class="subject">{{$ponencia->updated_at}}</td>
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