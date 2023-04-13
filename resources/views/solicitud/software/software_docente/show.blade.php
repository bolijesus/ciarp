@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.solicitud')}}">Solicitud</a></li>
    @if(session()->exists('PAG_SOLICITUD-SOFTWARE-DOC'))
    <li><a href="{{route('software.index')}}">Software</a></li>
    @endif
    @if(session()->exists('PAG_SOLICITUD-SOFTWARE-ADM'))
    <li><a href="{{route('software.indexadmin')}}">Software</a></li>
    @endif
    <li class="active"><a>Ver Software</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    GESTIÓN DE SOFTWARE - VER UN SOFTWARE
                </h2>
            </div>
            <div class="body">
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h1 class="card-inside-title">DATOS DEL SOFTWARE SELECCIONADO</h1>
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
                                    <td class="contact"><b>Titular</b></td>
                                    <td class="subject">{{$software->titular}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Autores</b></td>
                                    <td class="subject">{{$software->autores}}</td>
                                </tr>
                            </tr><tr class="read">
                            <td class="contact"><b>¿Impacta En Comunidad Universitaria?</b></td>
                            <td class="subject">{{$software->impacto_upc}}</td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>¿Evidencia Crédito a la UPC?</b></td>
                            <td class="subject">{{$solicitud->evd_cred_upc}}</td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Número de Actores</b></td>
                            <td class="subject">{{$solicitud->num_autores}}</td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Ejecutable</b></td>
                            <td><a target="_blank" href="{{asset('docs/software/ejecutable/'.$software->ejecutable)}}">{{$software->ejecutable}}</a></td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Codigo Fuente</b></td>
                            <td><a target="_blank" href="{{asset('docs/software/codigo/'.$software->codigo)}}">{{$software->codigo}}</a></td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Instrucciones</b></td>
                            <td><a target="_blank" href="{{asset('docs/software/instrucciones/'.$software->instrucciones)}}">{{$software->instrucciones}}</a></td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Certificado Impacto</b></td>
                            <td><a target="_blank" href="{{asset('docs/software/impacto/'.$software->cert_imp_upc)}}">{{$software->cert_imp_upc}}</a></td>
                        </tr><tr class="read">
                            <td class="contact"><b>Manuales</b></td>
                            <td><a target="_blank" href="{{asset('docs/software/manual/'.$software->manual)}}">{{$software->manual}}</a></td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Certificado Registro</b></td>
                            <td><a target="_blank" href="{{asset('docs/software/cer_registro/'.$software->cert_registro)}}">{{$software->cert_registro}}</a></td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>CVLAC</b></td>
                            <td><a target="_blank" href="{{asset('docs/software/cvlac/'.$solicitud->cvlac)}}">{{$solicitud->cvlac}}</a></td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>GrupLAC</b></td>
                            <td><a target="_blank" href="{{asset('docs/software/gruplac/'.$solicitud->gruplac)}}">{{$solicitud->gruplac}}</a></td>
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
                            <td class="subject">{{$software->created_at}}</td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Modificado</b></td>
                            <td class="subject">{{$software->updated_at}}</td>
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