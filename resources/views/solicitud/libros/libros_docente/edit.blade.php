@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.solicitud')}}">Solicitud</a></li>
    <li><a href="{{route('libro.index')}}">Libros</a></li>
    <li class="active"><a>Editar Libro</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    GESTIÓN DE LIBROS - EDITAR UN LIBRO
                </h2>
            </div>
            <div class="body">
                <div class="alert bg-green alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong>Edite los datos del libro.</strong>Para realizar la solicitud recuerde tener a la mano todos los archivos que pide el sistema para poder validar la información.
                    </br>Mediante este formulario radico ante la CIARP de la Universidad Popular del Cesar, sulicitud de evaluación de la producción académica aquí relacionada, siguiendo los lineamientos establecidos en el decreto 1279 de Junio de 2002 y el acuerdo del Consejo Superior Universitario N° 005 de 20 de enero de 2004.
                    </br><strong>NOTA:</strong> La veracidad de los datos que registre en el formulario y los documentos que adjunte, son responsabilidad del docente solicitante. El incumplimiento al proceso puede ser causal de devolución.
                </div>
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h1 class="card-inside-title">DATOS DEL LIBRO: {{$libro->solicitud->titulo}}</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        {!! Form::open(['route'=>['libro.update',$libro],'method'=>'PUT','class'=>'form-horizontal','files'=>'true'])!!}
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-md-4">
                                        <div class="form-line">
                                            <label class="control-label">Titulo</label>
                                            {!! Form::text('titulo',$libro->solicitud->titulo,['class'=>'form-control','placeholder'=>'Titulo del libro','required']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-line">
                                            <label class="control-label">Tipo de Producto</label>
                                            {!! Form::select('tipo',['LT'=>'LIBRO DE TEXTO','LI'=>'LIBRO RESULTADO DE UNA LABOR DE INVESTIGACIÓN','LE'=>'LIBRO DE ENSAYO'],$libro->tipo,['class'=>'form-control','placeholder'=>'-- Seleccione una opción --','required']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-line">
                                            <label class="control-label">Grupo de Investigación</label>
                                            {!! Form::text('grupo_investigacion',$libro->solicitud->grupo_investigacion,['class'=>'form-control','placeholder'=>'Grupo al cual pertenece','required']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-3">
                                        <div class="form-line">
                                            <label class="control-label">Editorial</label>
                                            {!! Form::text('editorial',$libro->editorial,['class'=>'form-control','placeholder'=>'Nombre de la editorial','required']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-line">
                                            <label class="control-label">Fecha de Publicación</label>
                                            {!! Form::date('fecha_publicacion',$libro->fecha_publicacion,['class'=>'form-control','placeholder'=>'Fecha de publicación del libro','required']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-line">
                                            <label class="control-label">Idioma</label>
                                            {!! Form::text('idioma',$libro->idioma,['class'=>'form-control','placeholder'=>'Idioma del libro','required']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-line">
                                            <label class="control-label">¿Evidencia Crédito a la UPC?</label>
                                            {!! Form::select('evd_cred_upc',['SI'=>'SI','NO'=>'NO'],$libro->solicitud->evd_cred_upc,['class'=>'form-control','placeholder'=>'-- Seleccione una opción --','required']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-3">
                                        <div class="form-line">
                                            <label class="control-label">Número Total de Autores</label>
                                            {!! Form::number('num_autores',$libro->solicitud->num_autores,['class'=>'form-control','placeholder'=>'Total de autores de la obra']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-line">
                                            <label class="control-label">ISBN</label>
                                            {!! Form::text('isbn',$libro->solicitud->isbn,['class'=>'form-control','placeholder'=>'ISBN','required']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-line">
                                            <label class="control-label">Número de Identificación</label>
                                            {!! Form::text('num_editorial',$libro->num_editorial,['class'=>'form-control','placeholder'=>'Num. de identificación de la base de datos reconocida por la editorial','required']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <p style="color:red;">NOTA: Si no desea actualizar los archivos, no seleccione ningun campo para cargar documentos.</p>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <div class="form-line">
                                            <label class="control-label">Libro</label>
                                            <input class="form-control" type="file" name="libro_pdf">
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
                                            <label class="control-label">Certificado de Vicerrectoría de Investigaciones</label>
                                            <input class="form-control" type="file" name="cert_vicerrectoria">    
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <br/><br/><a href="{{route('libro.index')}}" class="btn bg-red waves-effect">Cancelar</a>
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