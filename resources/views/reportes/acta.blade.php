@extends('layouts.admin')
@section('style')
<style type="text/css">
    .btn.btn-circle.btn-lg {
        width: 100px;
        height: 100px;
        font-size: 3em;
    }
    .btn.btn-circle {
        -webkit-border-radius: 200% !important;
        -moz-border-radius: 200% !important;
        -ms-border-radius: 200% !important;
        -o-border-radius: 200% !important;
        border-radius: 200% !important;
        width: 70px;
        height: 70px;
        padding: 10px;
        font-size: 2em;
    }
    .btn.ripple-infinite {
        position: relative;
        overflow: hidden;
    }
    .btn-danger, .label-danger, .alert-danger, .badge-danger {
        color: #fff !important;
        border: none !important;
        background-color: #FF6656 !important;
    }
    .btn {
        border-width: 2px;
    }
    .btn-lg, .btn-group-lg>.btn {
        padding: 18px 27px;
        font-size: 19px;
        line-height: 1.3333333;
        border-radius: 6px;
    }
    .btn-danger {
        color: #ffffff;
        background-color: #e74c3c;
        border-color: #e74c3c;
    }
    a, a:hover {
        -webkit-text-decoration: none;
        -moz-text-decoration: none;
        -ms-text-decoration: none;
        -o-text-decoration: none;
        text-decoration: none;
        color: #2196F3;
        font-weight: bold;
    }
    a {
        color: #18bc9c;
        text-decoration: none;
    }
    a {
        background-color: transparent;
    }
    .btn.ripple-infinite div:before, .btn.ripple-infinite div:after {
        -webkit-transition: all 0.7s ease !important;
        -moz-transition: all 0.7s ease !important;
        -ms-transition: all 0.7s ease !important;
        -o-transition: all 0.7s ease !important;
        transition: all 0.7s ease !important;
        content: "" !important;
        position: absolute !important;
        background: rgba(255, 255, 255, 0.2) !important;
        z-index: 99 !important;
        left: 15% !important;
        right: 15% !important;
        top: -50% !important;
        bottom: -50% !important;
        -webkit-border-radius: 200% !important;
        -moz-border-radius: 200% !important;
        -ms-border-radius: 200% !important;
        -o-border-radius: 200% !important;
        border-radius: 200% !important;
        -webkit-animation: pulseA ease 1.4s infinite !important;
        -moz-animation: pulseA ease 1.4s infinite !important;
        -ms-animation: pulseA ease 1.4s infinite !important;
        -o-animation: pulseA ease 1.4s infinite !important;
        animation: pulseA ease 1.4s infinite !important;
    }

</style>
@endsection
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.reporte')}}"> Reportes</a></li>
    <li class="active"><a>Acta</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    GESTIÓN REPORTES - GENERAR ACTA
                </h2>
            </div>
            <div class="body">
                <div class="alert bg-green alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    Genere el acta de asignación de puntos del período que seleccione.
                </div>
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-md-6">
                                <div class="form-line">
                                    <label class="control-label">Año</label>
                                    {!! Form::number('anio',null,['class'=>'form-control','placeholder'=>'Año','min'=>'1990','max'=>'2070','required','id'=>'anio']) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-line">
                                    <label class="control-label">Periodo</label>
                                    {!! Form::select('periodo',['1'=>'1','2'=>'2'],null,['class'=>'form-control','placeholder'=>'-- Seleccione una opción --','required','id'=>'periodo']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <button onclick="pdf()" class="btn btn-success icon-btn " ><i class="material-icons">search</i>Consultar</button>      
                            </div>
                        </div>
                        <div class="table-responsive" style="margin-top: 180px">
                            <table id="tabla" class="table table-bordered table-striped table-hover table-responsive table-condensed" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Número</th>
                                        <th>Docente</th>
                                        <th>Fundamento</th>
                                        <th>Puntos</th>
                                    </tr>
                                </thead>
                                <tbody id="tb2">

                                </tbody>
                            </table>
                        </div>
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
    $(document).ready(function () {
        $('#tabla').DataTable();
    });
    function pdf() {
        $("#tb2").html("");
        var u = $("#anio").val();
        var p = $("#periodo").val();
        if (u == null || p == null) {
            notify('Alerta', 'Debe indicar todos los parámetros para continuar', 'warning');
        }
        if (u > 1990 && u < 2070) {
            $.ajax({
                type: 'GET',
                url: url + "reportes/reporte/acta/" + u + "/" + p + "/pdf",
                data: {},
            }).done(function (msg) {
                if (msg !== "null") {
                    var m = JSON.parse(msg);
                    var html = "";
                    $.each(m, function (index, item) {
                        html = html + "<tr><td>" + item.num + "</td>";
                        html = html + "<td>" + item.docente + "</td>";
                        html = html + "<td>" + item.fundamento + "</td>";
                        html = html + "<td>" + item.puntos + "</td>";
                        +"</tr>";
                    });
                    $("#tb2").html(html);
                } else {
                    notify('Atención', 'No hay solicitudes para los parametros seleccionados', 'error');
                }
            });
        } else {
            notify('Alerta', 'El valor del campo año no es valido.', 'warning');
        }
    }
    function pdfviejo() {
        var u = $("#anio").val();
        var p = $("#periodo").val();
        if (u == null || p == null) {
            notify('Alerta', 'Debe indicar todos los parámetros para continuar', 'warning');
        } else {
            if (u > 1990 && u < 2070) {
                var a = document.createElement("a");
                a.target = "_blank";
                a.href = url + "reportes/reporte/acta/" + u + "/" + p + "/pdf";
                a.click();
            } else {
                notify('Alerta', 'El valor del campo año no es valido.', 'warning');
            }
        }
    }

    function excel() {
        var u = $("#anio").val();
        var p = $("#periodo").val();
        if (u == null || p == null) {
            notify('Alerta', 'Debe indicar todos los parámetros para continuar', 'warning');
        } else {
            if (u > 1990 && u < 2070) {
                var a = document.createElement("a");
                a.target = "_blank";
                a.href = url + "reportes/reporte/acta/" + u + "/" + p + "/pdf";
                a.click();
            } else {
                notify('Alerta', 'El valor del campo año no es valido.', 'warning');
            }
        }
    }
</script>
@endsection