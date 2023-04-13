@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.solicitud')}}">Solicitud</a></li>
    <li><a href="{{route('articulo.index')}}">Artículos</a></li>
    <li class="active"><a>Agregar Artículo</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    GESTIÓN DE ARTÍCULOS CIENTÍFICOS - AGREGAR NUEVO ARTÍCULO
                </h2>
            </div>
            <div class="body">
                <div class="alert bg-green alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong>Agregue nuevos artículos científicos.</strong> Para realizar la solicitud recuerde tener a la mano todos los archivos que pide el sistema para poder validar la información.
                    </br>Mediante este formulario radico ante la CIARP de la Universidad Popular del Cesar, sulicitud de evaluación de la producción académica aquí relacionada, siguiendo los lineamientos establecidos en el decreto 1279 de Junio de 2002 y el acuerdo del Consejo Superior Universitario N° 005 de 20 de enero de 2004.
                    </br><strong>NOTA:</strong> La veracidad de los datos que registre en el formulario y los documentos que adjunte, son responsabilidad del docente solicitante. El incumplimiento al proceso puede ser causal de devolución.
                </div>
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h1 class="card-inside-title">DATOS DEL ARTÍCULO</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        {!! Form::open(['route'=>'articulo.store','method'=>'POST','class'=>'form-horizontal','files'=>'true'])!!}
                        <input type="hidden" name="docente_id" value="{{$docente->id}}" />
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="form-line">
                                        <label class="control-label">Titulo</label>
                                        {!! Form::text('titulo',null,['class'=>'form-control','placeholder'=>'Titulo del artículo científico','required']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-4">
                                    <div class="form-line">
                                        <label class="control-label">Indexada</label>
                                        {!! Form::select('indexada',['SI'=>'SI','NO'=>'NO'],null,['class'=>'form-control','placeholder'=>'-- Seleccione una opción --','required','id'=>'indexada','onchange'=>'validar()']) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-line">
                                        <label class="control-label">Clasificación de la Revista</label>
                                        {!! Form::select('clasificacion',['A1'=>'A1','A2'=>'A2','B'=>'B','C'=>'C'],null,['class'=>'form-control','placeholder'=>'-- Seleccione una opción --','required','id'=>'clasificacion']) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-line">
                                        <label class="control-label">Grupo de Investigación</label>
                                        {!! Form::text('grupo_investigacion',null,['class'=>'form-control','placeholder'=>'Grupo al cual pertenece','required']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-3">
                                    <div class="form-line">
                                        <label class="control-label">Fecha de Publicación</label>
                                        {!! Form::date('fechapublicacion',null,['class'=>'form-control','placeholder'=>'Fecha de publicación del artículo','required']) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-line">
                                        <label class="control-label">Nombre de la Revista</label>
                                        {!! Form::text('nombre_revista',null,['class'=>'form-control','placeholder'=>'Nombre de la revista','required']) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-line">
                                        <label class="control-label">Idioma</label>
                                        {!! Form::text('idioma',null,['class'=>'form-control','placeholder'=>'Idioma','required']) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-line">
                                        <label class="control-label">¿Evidencia Filiación de la UPC?</label>
                                        {!! Form::select('evd_filiacion_upc',['SI'=>'SI','NO'=>'NO'],null,['class'=>'form-control','placeholder'=>'-- Seleccione una opción --','required']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-3">
                                    <div class="form-line">
                                        <label class="control-label">Número Total de Autores</label>
                                        {!! Form::number('num_autores',null,['class'=>'form-control','placeholder'=>'Número de autores']) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-line">
                                        <label class="control-label">ISSN</label>
                                        {!! Form::text('issn',null,['class'=>'form-control','placeholder'=>'ISSN','required']) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-line">
                                        <label class="control-label">Puntos Salariales Solicitados</label>
                                        {!! Form::number('ps_solicitados',null,['class'=>'form-control','placeholder'=>'Solicitados por el docente','id'=>'puntosps']) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-line">
                                        <label class="control-label">Bonificaciones Solicitadas</label>
                                        {!! Form::number('bo_solicitados',null,['class'=>'form-control','placeholder'=>'Solicitadas por el docente','id'=>'puntosbo']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Artículo</label>
                                        <input class="form-control" type="file" required="required" name="articulo_pdf">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">CVLAC</label>
                                        <input class="form-control" type="file" required="required" name="cvlac">    
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">GrupLAC</label>
                                        <input class="form-control" type="file" required="required" name="gruplac">    
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Publindex - Colciencias</label>
                                        <input class="form-control" type="file" required="required" name="publindex">    
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

    function validar() {
        var index = $("#indexada").val();
        if (index == "NO") {
            $("#clasificacion").val("");
            $("#puntosps").val("");
            $("#clasificacion").attr('disabled', true);
            $("#puntosps").attr('disabled', true);
            $("#puntosbo").removeAttr('disabled');
        } else {
            $("#puntosbo").val("");
            $("#clasificacion").removeAttr('disabled');
            $("#puntosps").removeAttr('disabled');
            $("#puntosbo").attr('disabled', true);
        }
    }
</script>
@endsection