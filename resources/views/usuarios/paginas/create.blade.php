@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.usuarios')}}">Usuarios</a></li>
    <li><a href="{{route('pagina.index')}}">Páginas del Sistema</a></li>
    <li class="active"><a>Crear Página</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    USUARIOS DEL SISTEMA - PÁGINAS DEL SISTEMA
                </h2>
            </div>
            <div class="body">
                <div class="alert bg-green alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong>Agregue nuevas páginas,</strong> el nombre de la página no debe llevar acentos, eñes (ñ) ni caracteres especiales, el nombre de la página debe iniciar con "PAG_" seguido del nombre que usted desee. Las paginas o ítems de los módulos del sistema son las funcionalidades más específicas o detalladas de los módulos. Ejemplo de página general: PAG_MODULOS, PAG_PAGINAS, PAG_USUARIOS, PAG_PRIVILEGIOS, ETC.
                </div>
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h1 class="card-inside-title">DATOS DE LA PÁGINA</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        {!! Form::open(['route'=>'pagina.store','method'=>'POST','class'=>'form-horizontal'])!!}
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <br/>{!! Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Escriba el nombre de la página','required']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <br/>{!! Form::text('descripcion',null,['class'=>'form-control','placeholder'=>'Descripción de la página (Opcional)']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <br/><br/><a href="{{route('pagina.index')}}" class="btn bg-red waves-effect">Cancelar</a>
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