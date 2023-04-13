@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.usuarios')}}">Usuarios</a></li>
    <li class="active"><a>Editar/Eliminar Usuario</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    USUARIOS DEL SISTEMA - EDITAR/ELIMINAR USUARIO
                </h2>
            </div>
            <div class="body">
                <div class="alert bg-green alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong>Edite ó elimine un usuario del sistema.</strong>
                </div>
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h1 class="card-inside-title">DATOS DEL USUARIO</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        {!! Form::open(['route'=>['usuario.update',$user],'method'=>'PUT','class'=>'form-horizontal col-md-12'])!!}
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <br/>{!! Form::text('identificacion',$user->identificacion,['class'=>'form-control','placeholder'=>'Escriba el número de identificación del usuario, con éste tendrá acceso al sistema','required']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <br/>{!! Form::text('nombres',$user->nombres,['class'=>'form-control','placeholder'=>'Escriba los nombres del usuario','required','id'=>'txt_nombres']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <br/>{!! Form::text('apellidos',$user->apellidos,['class'=>'form-control','placeholder'=>'Escriba los apellidos del usuario','required','id'=>'txt_apellidos']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <br/>{!! Form::email('email',$user->email,['class'=>'form-control','placeholder'=>'Escriba el correo electrónico del usuario','required','id'=>'txt_email']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <br/>{!! Form::select('estado',['ACTIVO'=>'ACTIVO','INACTIVO'=>'INACTIVO'],$user->estado,['class'=>'form-control','placeholder'=>'-- Seleccione Estado del Usuario --','required']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <br/>{!! Form::select('grupos[]',$grupos,$user->grupousuarios,['class'=>'form-control chosen-select','placeholder'=>'Seleccione los Grupos o Roles de Usuarios','required','multiple']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <br/><br/><a href="{{route('admin.usuarios')}}" class="btn bg-red waves-effect">Cancelar</a>
                                <button class="btn bg-indigo waves-effect" type="reset">Limpiar Formulario</button>
                                {!! Form::submit('Guardar',['class'=>'btn bg-green waves-effect']) !!}
                                <a href="{{ route('usuario.delete',$user->id)}}" class="btn bg-red waves-effect">Eliminar Usuario</a>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    USUARIOS DEL SISTEMA - CAMBIAR CONTRASEÑA
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a data-toggle="modal" data-target="#mdModal">Ayuda</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h1 class="card-inside-title">DATOS DEL USUARIO</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        {!! Form::open(['route'=>['usuario.cambiarPass',$user],'method'=>'POST','class'=>'form-horizontal col-md-12'])!!}
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <br/><input type="text" name="identificacion2" value="{{$user->identificacion}}" class="form-control" readonly="" required="required" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <label>Escriba la Nueva Contraseña</label>
                                    <br/><input type="password" name="pass1" placeholder="Mínimo 6 caracteres" class="form-control" required="required" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <label>Vuelva a Escribir La Nueva Contraseña</label>
                                    <br/><input type="password" name="pass2" placeholder="Mínimo 6 caracteres" class="form-control" required="required" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <button class="btn bg-indigo waves-effect" type="reset">Limpiar</button>
                                <button class="btn bg-green waves-effect" type="submit">Guardar</button>
                            </div>
                        </div> 
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="mdModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">SOBRE LOS USUARIOS</h4>
            </div>
            <div class="modal-body">
                <strong>Edite ó elimine un usuario del sistema. Además, puede cambiar la contraseña.</strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">ACEPTAR</button>
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