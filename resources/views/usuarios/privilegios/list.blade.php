@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.usuarios')}}">Usuarios</a></li>
    <li class="active"><a>Privilegios a Páginas</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    USUARIOS DEL SISTEMA - PRIVILEGIOS A PÁGINAS
                </h2>
            </div>
            <div class="body">
                <div class="alert bg-green alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    Los privilegios a páginas son los permisos que se deben asignar a los grupos de usuarios o roles para acceder a las funciones específicas de los módulos, es decir, sus páginas. En este sentido, si añade páginas a un grupo de usuario usted le estaría concediendo permisos al grupo para actuar sobre dichas páginas.<br/>
                    <strong>Modo de Operar:</strong> Seleccione un grupo de usuario y agregue permisos de izquierda a derecha o elimine privilegios del grupo pasando de derecha a izquierda.
                </div>
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h1 class="card-inside-title">GESTIONAR LAS PÁGINAS DE UN GRUPO DE USUARIO</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="form-line">
                                <br/>{!! Form::select('grupousuario_id',$grupos,null,['class'=>'form-control','placeholder'=>'Seleccione Grupo o Rol de Usuario','onchange="traerData()"','id'=>'grupousuario_id']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="body bg-teal">
                                    PÁGINAS DEL SISTEMA
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-line">
                                {!! Form::select('paginas[]',$paginas,null,['class'=>'form-control','placeholder'=>'-- Seleccione una opción --','multiple','size="20"','id'=>'paginas']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2" style="margin-top: 15%;">
                        <div class="col-md-12">
                            <center><button type="button" class="btn bg-green waves-effect" onclick="agregar()"> Agregar </button></center>
                        </div>
                        <div class="col-md-12">
                            <center><button type="button" class="btn btn-warning waves-effect" onclick="retirar()"> Quitar </button></center>
                        </div>
                        <div class="col-md-12">
                            <center><button type="button" class="btn bg-green waves-effect" onclick="agregarTodas()"> Agregar Todo </button></center>
                        </div>
                        <div class="col-md-12">
                            <center><button type="button" class="btn btn-warning waves-effect" onclick="retirarTodas()"> Quitar Todo </button></center>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="body bg-teal">
                                    PRIVILEGIOS DEL GRUPO
                                </div>
                            </div>
                        </div>
                        {!! Form::open(['route'=>'grupousuario.guardar','method'=>'POST','class'=>'form-horizontal','name'=>'form-privilegios','id'=>'form-privilegios'])!!}
                        {!! Form::hidden('id',null,['class'=>'form-control','id'=>'id']) !!}
                        <div class="form-group">
                            <div class="form-line">
                                <select name="privilegios[]" id="privilegios" class="form-control" multiple="" size="20" required="required"></select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <br/><button type="submit" id="btn-enviar" class="btn bg-teal waves-effect btn-block">Guardar los Cambios Para el Grupo Seleccionado</button>
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
<script type="text/javascript">
    $(document).ready(function () {
        $("#btn-enviar").click(function (e) {
            validar(e);
        });
    });

    function validar(e) {
        e.preventDefault();
        var id = $("#id").val();
        if (id.length === 0) {
            notify('Atención', 'Debe seleccionar un grupo de usuarios para agregar privilegios.', 'warning');
        } else {
            $('#privilegios option').each(function () {
                var valor = $(this).attr('value');
                $("#privilegios").find("option[value='" + valor + "']").prop("selected", true);
            });
            $("#form-privilegios").submit();
        }
    }

    function agregar() {
        var id = $("#grupousuario_id").val();
        if (id === null) {
            notify('Atención', 'Debe seleccionar un grupo de usuarios para agregar privilegios.', 'warning');
        } else {
            $.each($('#paginas :selected'), function () {
                var valor = $(this).val();
                var texto = $(this).text();
                if (!existe(valor)) {
                    $("#privilegios").append("<option value='" + valor + "'>" + texto + "</option>");
                    $("#paginas").find("option[value='" + valor + "']").prop("disabled", true);
                }
            });
        }
    }

    function agregarTodas() {
        var id = $("#grupousuario_id").val();
        if (id === null) {
            notify('Atención', 'Debe seleccionar un grupo de usuarios para agregar privilegios.', 'warning');
        } else {
            $('#paginas option').each(function () {
                var valor = $(this).attr('value');
                var texto = $(this).text();
                if (texto !== "-- Seleccione una opción --") {
                    if (!existe(valor)) {
                        $("#privilegios").append("<option value='" + valor + "'>" + texto + "</option>");
                        $("#paginas").find("option[value='" + valor + "']").prop("disabled", true);
                    }
                }
            });
        }
    }

    function existe(valor) {
        var array = [];
        $("#privilegios option").each(function () {
            array.push($(this).attr('value'));
        });
        var index = $.inArray(valor, array);
        if (index !== -1) {
            return true;
        } else {
            return false;
        }
    }

    function retirar() {
        $.each($('#privilegios :selected'), function () {
            var valor = $(this).val();
            $("#paginas").find("option[value='" + valor + "']").prop("disabled", false);
            $(this).remove();
        });
    }

    function retirarTodas() {
        $('#privilegios option').each(function () {
            var valor = $(this).attr('value');
            $("#paginas").find("option[value='" + valor + "']").prop("disabled", false);
            $(this).remove();
        });
    }

    function traerData() {
        var id = $("#grupousuario_id").val();
        $("#id").val(id);
        $.ajax({
            type: 'GET',
            url: url + "/usuarios/grupousuario/" + id + "/privilegios",
            data: {},
        }).done(function (msg) {
            $('#privilegios option').each(function () {
                $(this).remove();
            });
            if (msg !== "null") {
                var m = JSON.parse(msg);
                $('#paginas option').each(function () {
                    var valor = $(this).attr('value');
                    $("#paginas").find("option[value='" + valor + "']").prop("disabled", false);
                });
                $.each(m, function (index, item) {
                    $("#privilegios").append("<option value='" + item.id + "'>" + item.value + "</option>");
                    $("#paginas").find("option[value='" + item.id + "']").prop("disabled", true);
                });
            } else {
                notify('Atención', 'El grupo de usuarios seleccionado no tiene privilegios asignados aún.', 'error');
                $('#paginas option').each(function () {
                    var valor = $(this).attr('value');
                    $("#paginas").find("option[value='" + valor + "']").prop("disabled", false);
                });
            }
        });
    }
</script>
@endsection