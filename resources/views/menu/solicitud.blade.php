
@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li class="active"><a href="{{route('admin.solicitud')}}">Solicitudes</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    MÓDULO SOLICITUDES<small>GESTIÓN DE LAS SOLICITUDES REALIZADAS Y TODAS LAS CONFIGURACIONES NECESARIAS PARA SU ADMINISTRACIÓN</small>
                </h2>
            </div>
            <div class="body">
                <div class="row clearfix">
                    <div class="col-md-12">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs tab-nav-right" role="tablist">
                            @if(session()->exists('PAG_AGREGAR-DOCENTE'))
                            <li role="presentation" class="active"><a href="#home_animation_1" data-toggle="tab"><i class="material-icons">assignment</i> RECURSOS ACADÉMICOS</a></li>
                            @endif
                            <li role="presentation"><a href="#articulos_animation_1" data-toggle="tab"><i class="material-icons">description</i> ARTICULOS CIENTÍFICOS</a></li>
                            <li role="presentation"><a href="#libros_animation_1" data-toggle="tab"><i class="material-icons">book</i> LIBROS</a></li>
                            <li role="presentation"><a href="#software_animation_1" data-toggle="tab"><i class="material-icons">code</i> SOFTWARE</a></li>
                            <li role="presentation"><a href="#ponencias_animation_1" data-toggle="tab"><i class="material-icons">business</i> PONENCIAS</a></li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            @if(session()->exists('PAG_AGREGAR-DOCENTE'))
                            <div role="tabpanel" class="tab-pane animated flipInX active" id="home_animation_1">
                                <b>CARGA ADMINISTRATIVA</b>
                                <br/><br/>
                                <div class="button-demo">
                                    @if(session()->exists('PAG_FECHAS-CIERRE'))
                                    <a href="{{route('fecha.index')}}" class="btn bg-indigo waves-effect">
                                        <div><span>FECHAS DE CIERRE</span><span class="ink animate"></span></div>
                                    </a>
                                    @endif
                                    @if(session()->exists('PAG_FECHAS-PQR'))
                                    <a href="{{route('fechapqr.index')}}" class="btn bg-indigo waves-effect">
                                        <div><span>FECHAS DE PQR</span><span class="ink animate"></span></div>
                                    </a>
                                    @endif
                                    @if(session()->exists('PAG_AGREGAR-DOCENTE'))
                                    <a href="{{route('docente.index')}}" class="btn bg-indigo waves-effect">
                                        <div><span>AGREGAR DOCENTE</span><span class="ink animate"></span></div>
                                    </a>
                                    @endif
                                </div>
                            </div>
                            @endif
                            <div role="tabpanel" class="tab-pane animated flipInX" id="articulos_animation_1">
                                <b>ARTÍCULOS CIENTÍFICOS</b>
                                <br/><br/>
                                <div class="button-demo">
                                    @if(session()->exists('PAG_SOLICITUD-ARTICULO-ADM'))
                                    <a href="{{route('articulo.indexadmin')}}" class="btn bg-amber waves-effect">
                                        <div><span>ARTÍCULOS CIENTÍFICOS</span><span class="ink animate"></span></div>
                                    </a>
                                    @endif
                                    @if(session()->exists('PAG_SOLICITUD-ARTICULO-DOC'))
                                    <a href="{{route('articulo.index')}}" class="btn bg-green waves-effect">
                                        <div><span>AGREGAR ARTÍCULOS</span><span class="ink animate"></span></div>
                                    </a>
                                    @endif
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane animated flipInX" id="libros_animation_1">
                                <b>LIBROS</b>
                                <br/><br/>
                                <div class="button-demo">
                                    @if(session()->exists('PAG_SOLICITUD-LIBRO-ADM'))
                                    <a href="{{route('libro.indexadmin')}}" class="btn bg-blue-grey waves-effect">
                                        <div><span>LIBROS</span><span class="ink animate"></span></div>
                                    </a>
                                    @endif
                                    @if(session()->exists('PAG_SOLICITUD-LIBRO-DOC'))
                                    <a href="{{route('libro.index')}}" class="btn bg-blue-grey waves-effect">
                                        <div><span>AGREGAR LIBROS</span><span class="ink animate"></span></div>
                                    </a>
                                    @endif
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane animated flipInX" id="software_animation_1">
                                <b>SOFTWARE</b>
                                <br/><br/>
                                <div class="button-demo">
                                    @if(session()->exists('PAG_SOLICITUD-SOFTWARE-ADM'))
                                    <a href="{{route('software.indexadmin')}}" class="btn bg-deep-orange waves-effect">
                                        <div><span>SOFTWARE</span><span class="ink animate"></span></div>
                                    </a>
                                    @endif
                                    @if(session()->exists('PAG_SOLICITUD-SOFTWARE-DOC'))
                                    <a href="{{route('software.index')}}" class="btn bg-deep-orange waves-effect">
                                        <div><span>AGREGAR SOFTWARE</span><span class="ink animate"></span></div>
                                    </a>
                                    @endif
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane animated flipInX" id="ponencias_animation_1">
                                <b>PONENCIAS</b>
                                <br/><br/>
                                <div class="button-demo">
                                    @if(session()->exists('PAG_SOLICITUD-PONENCIA-ADM'))
                                    <a href="{{route('ponencia.indexadmin')}}" class="btn btn-warning waves-effect">
                                        <div><span>PONENCIAS</span><span class="ink animate"></span></div>
                                    </a>
                                    @endif
                                    @if(session()->exists('PAG_SOLICITUD-PONENCIA-DOC'))
                                    <a href="{{route('ponencia.index')}}" class="btn btn-warning waves-effect">
                                        <div><span>AGREGAR PONENCIAS</span><span class="ink animate"></span></div>
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection