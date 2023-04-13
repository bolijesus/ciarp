@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.pqr')}}"> Preguntas, Quejas y Reclamos</a></li>
    <li class="active"><a>Crear PQR</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    GESTIÓN PREGUNTAS,QUEJAS Y RECLAMOS - NUEVO PQR
                </h2>
            </div>
            <div class="body">
                <div class="alert bg-green alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong>Agregue nuevos pqr.</strong> Gestione las preguntas, quejas y reclamos realizadas.
                </div>
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h1 class="card-inside-title">DATOS DE LA PQR</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        {!! Form::open(['route'=>'pqr.store2','method'=>'POST','class'=>'form-horizontal'])!!}
                        <input type="hidden" name="solicitud_id" value="{{$solicitud->id}}" />
                        <input type="hidden" name="radicado" value="{{$solicitud->radicado}}" />
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Asunto</label>
                                        <input class="form-control" type="text" name="asunto" required="required" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Mensaje</label>
                                        <input class="form-control" type="text" required="required" name="mensaje" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <br/><br/><a href="{{route('pqr.index')}}" class="btn bg-red waves-effect">Cancelar</a>
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