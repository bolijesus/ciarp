@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.solicitud')}}">Solicitud</a></li>
    <li><a href="{{route('articulo.index')}}">Artículos</a></li>
    <li class="active"><a>Editar Artículo</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    GESTIÓN DE ARTICULOS CIENTIFICOS - EDITAR UN ARTICULO
                </h2>
            </div>
            <div class="body">
                <div class="alert bg-green alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong>Edite los datos del articulo.</strong>Para realizar la solicitud recuerde tener a la mano todos los archivos que pide el sistema para poder validar la información.
                    </br>Mediante este formulario radico ante la CIARP de la Universidad Popular del Cesar, sulicitud de evaluación de la producción académica aquí relacionada, siguiendo los lineamientos establecidos en el decreto 1279 de Junio de 2002 y el acuerdo del Consejo Superior Universitario N° 005 de 20 de enero de 2004.
                    </br><strong>NOTA:</strong> La veracidad de los datos que registre en el formulario y los documentos que adjunte, son responsabilidad del docente solicitante. El incumplimiento al proceso puede ser causal de devolución.
                </div>
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h1 class="card-inside-title">DATOS DEL ARTICULO: {{$articulo->solicitud->titulo}}</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        {!! Form::open(['route'=>['articulo.update',$articulo],'method'=>'PUT','class'=>'form-horizontal','files'=>'true'])!!}
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="form-line">
                                        <label class="control-label">Titulo</label>
                                        {!! Form::text('titulo',$articulo->solicitud->titulo,['class'=>'form-control','placeholder'=>'Titulo del artículo científico','required']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-4">
                                    <div class="form-line">
                                        <label class="control-label">Clasificación de la Revista</label>
                                        {!! Form::select('clasificacion',['A1'=>'A1','A2'=>'A2','B'=>'B','C'=>'C'],$articulo->clasificacion,['class'=>'form-control','placeholder'=>'-- Seleccione una opción --','required']) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-line">
                                        <label class="control-label">Indexada</label>
                                        {!! Form::select('indexada',['SI'=>'SI','NO'=>'NO'],$articulo->indexada,['class'=>'form-control','placeholder'=>'-- Seleccione una opción --','required']) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-line">
                                        <label class="control-label">Grupo de Investigación</label>
                                        {!! Form::text('grupo_investigacion',$articulo->solicitud->grupo_investigacion,['class'=>'form-control','placeholder'=>'Grupo al cual pertenece','required']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-3">
                                    <div class="form-line">
                                        <label class="control-label">Fecha de Publicación</label>
                                        {!! Form::date('fechapublicacion',$articulo->fechapublicacion,['class'=>'form-control','placeholder'=>'Fecha de publicación del artículo','required']) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-line">
                                        <label class="control-label">Nombre de la Revista</label>
                                        {!! Form::text('nombre_revista',$articulo->nombre_revista,['class'=>'form-control','placeholder'=>'Nombre de la revista','required']) !!}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-line">
                                        <label class="control-label">Idioma</label>
                                        {!! Form::text('idioma',$articulo->idioma,['class'=>'form-control','placeholder'=>'Idioma','required']) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-line">
                                        <label class="control-label">¿Evidencia Filiación de la UPC?</label>
                                        {!! Form::select('evd_filiacion_upc',['SI'=>'SI','NO'=>'NO'],$articulo->evd_filiacion_upc,['class'=>'form-control','placeholder'=>'-- Seleccione una opción --','required']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-3">
                                    <div class="form-line">
                                        <label class="control-label">Número Total de Autores</label>
                                        {!! Form::number('num_autores',$articulo->solicitud->num_autores,['class'=>'form-control','placeholder'=>'Número de autores']) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-line">
                                        <label class="control-label">ISSN</label>
                                        {!! Form::text('issn',$articulo->solicitud->issn,['class'=>'form-control','placeholder'=>'ISSN','required']) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-line">
                                        <label class="control-label">Puntos Salariales Solicitados</label>
                                        {!! Form::number('ps_solicitados',$articulo->ps_solicitados,['class'=>'form-control','placeholder'=>'Solicitados por el docente']) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-line">
                                        <label class="control-label">Bonificaciones Solicitadas</label>
                                        {!! Form::number('bo_solicitados',$articulo->bo_solicitados,['class'=>'form-control','placeholder'=>'Solicitadas por el docente']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <p style="color:red;">NOTA: Si no desea actualizar los archivos, no seleccione ningun campo para cargar documentos.</p>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Artículo</label>
                                        <input class="form-control" type="file" name="articulo_pdf">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">CVLAC</label>
                                        <input class="form-control" type="file" name="cvlac">    
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">GrupLAC</label>
                                        <input class="form-control" type="file" name="gruplac">    
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Publindex - Colciencias</label>
                                        <input class="form-control" type="file" name="publindex">    
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <br/><br/><a href="{{route('articulo.index')}}" class="btn bg-red waves-effect">Cancelar</a>
                                <button class="btn bg-indigo waves-effect" type="reset">Limpiar Formulario</button>
                                {!! Form::submit('Guardar',['class'=>'btn bg-green waves-effect']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(".chosen-select").chosen({});
</script>
@endsection