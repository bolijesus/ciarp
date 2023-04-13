@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.solicitud')}}">Solicitud</a></li>
    <li><a href="{{route('admin.solicitud')}}">Recursos Académicos</a></li>
    <li class="active"><a href="{{route('fecha.index')}}">Fechas de Cierre</a></li>
    <li class="active"><a>Editar Fecha</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    GESTIÓN DE FECHAS DE CIERRE - EDITAR FECHA
                </h2>
            </div>
            <div class="body">
                <div class="alert bg-green alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong>Edite los datos de la fecha.</strong>Gestione las fechas de cierre del sistema las cuales seran el plazo limite para los docentes realizar sus solicitudes. Recuerde de que solo una fecha puede estar en estado ACTIVA.
                </div>
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h1 class="card-inside-title">DATOS DE LA FECHA: {{$fecha->fechainicio." - ".$fecha->fechafin}}</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        {!! Form::open(['route'=>['fecha.update',$fecha],'method'=>'PUT','class'=>'form-horizontal'])!!}
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <p style="color:red;">NOTA: Si no desea actualizar el valor de las fechas, no seleccione ningun valor en los controles de fecha</p>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2">
                                    <div class="form-line">
                                        <label class="control-label">Estado</label>
                                        {!! Form::select('estado',['ACTIVA'=>'ACTIVA','INACTIVA'=>'INACTIVA'],$fecha->estado,['class'=>'form-control','placeholder'=>'-- Seleccione una opción --','required']) !!}
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-line">
                                        <label class="control-label">Fecha Inicio -- ACTUAL: <i>{{$fecha->fechainicio}}</i></label>
                                        <input class="form-control"  name="fechainicio1" type="datetime-local" /> 
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-line">
                                        <label class="control-label">Fecha Fin -- ACTUAL: <i>{{$fecha->fechafin}}</label>
                                        <input class="form-control"  name="fechafin1" type="datetime-local" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <br/><br/><a href="{{route('fecha.index')}}" class="btn bg-red waves-effect">Cancelar</a>
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