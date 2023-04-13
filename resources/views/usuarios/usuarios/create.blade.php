@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.usuarios')}}">Usuarios</a></li>
    <li class="active"><a>Crear Usuario</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    USUARIOS DEL SISTEMA - CREAR USUARIO
                </h2>
            </div>
            <div class="body">
                <div class="alert bg-green alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong>Agregue un usuario al sistema y registre su/sus roles de acceso</strong>. Puede crear un usuario llenando todos los campos, ó partir de las personas generales ó feligreses de la iglesia.
                </div>
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h1 class="card-inside-title">DATOS DEL USUARIO</h1>
                <div class="row clearfix">
                    <div class="col-md-12" style="margin-top: 20px;">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-line">
                                    {!! Form::text('id',null,['class'=>'form-control','placeholder'=>'Escriba la identificación a consultar','id'=>'id']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn bg-indigo btn-block waves-effect" disabled="disabled">Traer Persona</button>
                        </div>
                    </div>
                    <div class="col-md-12">
                        {!! Form::open(['route'=>'usuario.store','method'=>'POST','class'=>'form-horizontal col-md-12'])!!}
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <br/>{!! Form::text('identificacion',null,['class'=>'form-control','placeholder'=>'Escriba el número de identificación del usuario, con éste tendrá acceso al sistema','required']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <br/>{!! Form::text('nombres',null,['class'=>'form-control','placeholder'=>'Escriba los nombres del usuario','required','id'=>'txt_nombres']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <br/>{!! Form::text('apellidos',null,['class'=>'form-control','placeholder'=>'Escriba los apellidos del usuario','required','id'=>'txt_apellidos']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <br/>{!! Form::email('email',null,['class'=>'form-control','placeholder'=>'Escriba el correo electrónico del usuario','required','id'=>'txt_email']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <br/>{!! Form::select('estado',['ACTIVO'=>'ACTIVO','INACTIVO'=>'INACTIVO'],null,['class'=>'form-control','placeholder'=>'-- Seleccione Estado del Usuario --','required']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <br/>{!! Form::select('grupos[]',$grupos,null,['class'=>'form-control chosen-select','placeholder'=>'Seleccione los Grupos o Roles de Usuarios','required','multiple']) !!}
                                </div>
                            </div>
                            <div class="form-group"><br/>
                                <div class="form-line">
                                    {!! Form::password('password',['class'=>'form-control','required','placeholder'=>'Contraseña del Usuario']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <br/><br/><a href="{{route('admin.usuarios')}}" class="btn bg-red waves-effect">Cancelar</a>
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