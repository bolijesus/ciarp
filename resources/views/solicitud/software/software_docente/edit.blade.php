@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.solicitud')}}">Solicitud</a></li>
    <li><a href="{{route('software.index')}}">Software</a></li>
    <li class="active"><a>Editar Software</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    GESTIÓN DE SOFTWARE - EDITAR UN SOFTWARE
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
                <h1 class="card-inside-title">DATOS DEL SOFTWARE: {{$software->solicitud->titulo}}</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        {!! Form::open(['route'=>['software.update',$software],'method'=>'PUT','class'=>'form-horizontal','files'=>'true'])!!}
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <div class="form-line">
                                            <label class="control-label">Titulo</label>
                                            {!! Form::text('titulo',$software->solicitud->titulo,['class'=>'form-control','placeholder'=>'Titulo del software','required']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-line">
                                            <label class="control-label">Titular</label>
                                            {!! Form::text('titular',$software->titular,['class'=>'form-control','placeholder'=>'Titular del Software','required']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-4">
                                        <div class="form-line">
                                            <label class="control-label">Resultado de Evaluación</label>
                                            {!! Form::text('result_pares',$software->result_pares,['class'=>'form-control','placeholder'=>'Resultado de la evaluación de pares','required']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-line">
                                            <label class="control-label">¿Impacta En Comunidad Universitaria?</label>
                                            {!! Form::select('impacto_upc',['SI'=>'SI','NO'=>'NO'],$software->impacto_upc,['class'=>'form-control','placeholder'=>'-- Seleccione una opción --','required']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-line">
                                            <label class="control-label">¿Evidencia Crédito a la UPC?</label>
                                            {!! Form::select('evd_cred_upc',['SI'=>'SI','NO'=>'NO'],$software->solicitud->evd_cred_upc,['class'=>'form-control','placeholder'=>'-- Seleccione una opción --','required']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-4">
                                        <div class="form-line">
                                            <label class="control-label">Grupo de Investigación</label>
                                            {!! Form::text('grupo_investigacion',$software->solicitud->grupo_investigacion,['class'=>'form-control','placeholder'=>'Grupo al cual pertenece','required']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-line">
                                            <label class="control-label">Número Total de Autores</label>
                                            {!! Form::number('num_autores',$software->solicitud->num_autores,['class'=>'form-control','placeholder'=>'Total de autores de la obra']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-line">
                                            <label class="control-label">Codigo Fuente</label>
                                            <input class="form-control" type="file" required="required" name="codigo">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="form-line demo-tagsinput-area">
                                            <label class="control-label">Autores</label>
                                            </br><input type="text" class="form-control" data-role="tagsinput" name="autores" value="{{$software->autores}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <p style="color:red;">NOTA: Si no desea actualizar los archivos, no seleccione ningun campo para cargar documentos.</p>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="form-line">
                                            <label class="control-label">Ejecutable</label>
                                            <input class="form-control" type="file" name="ejecutable">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-4">
                                        <div class="form-line">
                                            <label class="control-label">Instruciones</label>
                                            <input class="form-control" type="file"  name="instrucciones">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-line">
                                            <label class="control-label">Certificación Impacto UPC</label>
                                            <input class="form-control" type="file" name="cer_imp_upc">    
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-line">
                                            <label class="control-label">CVLAC</label>
                                            <input class="form-control" type="file" name="cvlac">    
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-4">
                                        <div class="form-line">
                                            <label class="control-label">GrupLAC</label>
                                            <input class="form-control" type="file"  name="gruplac">    
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-line">
                                            <label class="control-label">Manuales Técnicos</label>
                                            <input class="form-control" type="file" name="manual" >    
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-line">
                                            <label class="control-label">Certificación Registro</label>
                                            <input class="form-control" type="file" name="cer_registro">    
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <br/><br/><a href="{{route('software.index')}}" class="btn bg-red waves-effect">Cancelar</a>
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