@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.reporte')}}"> Reportes</a></li>
    <li class="active"><a>Productividad</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    GESTIÓN REPORTES - PRODUCTIVIDAD
                </h2>
            </div>
            <div class="body">
                <div class="alert bg-green alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    Consulte la productividad en un rango de fecha, por tipo, por estado y por docente.
                </div>
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-md-4">
                                <div class="form-line">
                                    <label class="control-label">Estado</label>
                                    {!! Form::select('estado',['TODO'=>'TODO','EN ESPERA'=>'EN ESPERA','APROBADA'=>'APROBADA','RECHAZADA'=>'RECHAZADA'],null,['class'=>'form-control','placeholder'=>'-- Seleccione una opción --','required','id'=>'estado']) !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-line">
                                    <label class="control-label">Fecha Inicial</label>
                                    <input class="form-control" type="date" required="required" name="fechai" id="fechai">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-line">
                                    <label class="control-label">Fecha Final</label>
                                    <input class="form-control" type="date" required="required" name="fechaf" id="fechaf">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <div class="form-line">
                                    <label class="control-label">Tipo</label>
                                    {!! Form::select('tipo',['TODO'=>'TODO','ARTICULO'=>'ARTICULO','ARTICULO INDEXADO'=>'ARTICULO INDEXADO','LIBRO'=>'LIBRO','SOFTWARE'=>'SOFTWARE','PONENCIA'=>'PONENCIA'],null,['class'=>'form-control','placeholder'=>'-- Seleccione una opción --','required','id'=>'tipo']) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-line">
                                    <label class="control-label">Identificación Docente</label>
                                    {!! Form::text('numero_documento',null,['class'=>'form-control','placeholder'=>'Numero de documento del docente','id'=>'documento']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <button onclick="getSolicitudes()" class="btn btn-success icon-btn " ><i class="material-icons">search</i>Consultar</button>      
                    </div>
                </div>
                <div class="table-responsive" style="margin-top: 85px">
                    <table id="tabla" class="table table-bordered table-striped table-hover table-responsive table-condensed" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Radicado</th>
                                <th>Docente</th>
                                <th>Titulo</th>
                                <th>Tipo</th>
                                <th>Estado</th>
                                <th>Puntos Salariales</th>
                                <th>Bonificaciones</th>
                                <th>Creado</th>
                            </tr>
                        </thead>
                        <tbody id="tb2">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Line Chart -->
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>LINE CHART</h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);">Action</a></li>
                            <li><a href="javascript:void(0);">Another action</a></li>
                            <li><a href="javascript:void(0);">Something else here</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <canvas id="line_chart" height="150"></canvas>
            </div>
        </div>
    </div>
    <!-- #END# Line Chart -->
</div>
</div>
@endsection
@section('script')
<!-- Chart Plugins Js -->
<script src="{{ asset('js/chartjs/Chart.bundle.js')}}"></script>
<!-- Custom Js -->
<script src="{{ asset('js/admin.js')}}"></script>
<script>

                            $(document).ready(function () {
                                $('#tabla').DataTable();

                            });
                            $(".chosen-select").chosen({});


                            function getChartJs(type, meses, ps, bo) {
                                var config = null;

                                if (type === 'line') {
                                    config = {
                                        type: 'line',
                                        data: {
                                            labels: meses,
                                            datasets: [{
                                                    label: "Puntos Salariales Asignados",
                                                    data: ps,
                                                    borderColor: 'rgba(0, 188, 212, 0.75)',
                                                    backgroundColor: 'rgba(0, 188, 212, 0.3)',
                                                    pointBorderColor: 'rgba(0, 188, 212, 0)',
                                                    pointBackgroundColor: 'rgba(0, 188, 212, 0.9)',
                                                    pointBorderWidth: 1
                                                }, {
                                                    label: "Bonificaciones Asignadas",
                                                    data: bo,
                                                    borderColor: 'rgba(233, 30, 99, 0.75)',
                                                    backgroundColor: 'rgba(233, 30, 99, 0.3)',
                                                    pointBorderColor: 'rgba(233, 30, 99, 0)',
                                                    pointBackgroundColor: 'rgba(233, 30, 99, 0.9)',
                                                    pointBorderWidth: 1
                                                }]
                                        },
                                        options: {
                                            responsive: true,
                                            legend: false
                                        }
                                    }
                                } else if (type === 'bar') {
                                    config = {
                                        type: 'bar',
                                        data: {
                                            labels: ["January", "February", "March", "April", "May", "June", "July"],
                                            datasets: [{
                                                    label: "My First dataset",
                                                    data: [65, 59, 80, 81, 56, 55, 40],
                                                    backgroundColor: 'rgba(0, 188, 212, 0.8)'
                                                }, {
                                                    label: "My Second dataset",
                                                    data: [28, 48, 40, 19, 86, 27, 90],
                                                    backgroundColor: 'rgba(233, 30, 99, 0.8)'
                                                }]
                                        },
                                        options: {
                                            responsive: true,
                                            legend: false
                                        }
                                    }
                                } else if (type === 'radar') {
                                    config = {
                                        type: 'radar',
                                        data: {
                                            labels: ["January", "February", "March", "April", "May", "June", "July"],
                                            datasets: [{
                                                    label: "My First dataset",
                                                    data: [65, 25, 90, 81, 56, 55, 40],
                                                    borderColor: 'rgba(0, 188, 212, 0.8)',
                                                    backgroundColor: 'rgba(0, 188, 212, 0.5)',
                                                    pointBorderColor: 'rgba(0, 188, 212, 0)',
                                                    pointBackgroundColor: 'rgba(0, 188, 212, 0.8)',
                                                    pointBorderWidth: 1
                                                }, {
                                                    label: "My Second dataset",
                                                    data: [72, 48, 40, 19, 96, 27, 100],
                                                    borderColor: 'rgba(233, 30, 99, 0.8)',
                                                    backgroundColor: 'rgba(233, 30, 99, 0.5)',
                                                    pointBorderColor: 'rgba(233, 30, 99, 0)',
                                                    pointBackgroundColor: 'rgba(233, 30, 99, 0.8)',
                                                    pointBorderWidth: 1
                                                }]
                                        },
                                        options: {
                                            responsive: true,
                                            legend: false
                                        }
                                    }
                                } else if (type === 'pie') {
                                    config = {
                                        type: 'pie',
                                        data: {
                                            datasets: [{
                                                    data: [225, 50, 100, 40],
                                                    backgroundColor: [
                                                        "rgb(233, 30, 99)",
                                                        "rgb(255, 193, 7)",
                                                        "rgb(0, 188, 212)",
                                                        "rgb(139, 195, 74)"
                                                    ],
                                                }],
                                            labels: [
                                                "Pink",
                                                "Amber",
                                                "Cyan",
                                                "Light Green"
                                            ]
                                        },
                                        options: {
                                            responsive: true,
                                            legend: false
                                        }
                                    }
                                }
                                return config;
                            }


                            function getSolicitudes() {
                                $("#tb2").html("");
                                var ti = $("#tipo").val();
                                var esta = $("#estado").val();
                                var fi = $("#fechai").val();
                                var ff = $("#fechaf").val();
                                var doc = $("#documento").val();
                                if (ti == null || esta == null || fi.length <= 0 || ff.length <= 0) {
                                    notify('Alerta', 'Debe indicar todos los parámetros para continuar', 'warning');
                                }
                                if (doc.length <= 0) {
                                    doc = "null";
                                }
                                $.ajax({
                                    type: 'GET',
                                    url: url + "reportes/reporte/menu/" + esta + "/" + fi + "/" + ff + "/" + ti + "/" + doc + "/productividad",
                                    data: {},
                                }).done(function (msg) {
                                    if (msg !== "null") {
                                        var m = JSON.parse(msg);
                                        new Chart(document.getElementById("line_chart").getContext("2d"), getChartJs('line', m.meses, m.ps, m.bo));
                                        var html = "";
                                        $.each(m.data, function (index, item) {
                                            html = html + "<tr><td>" + item.radicado + "</td>";
                                            html = html + "<td>" + item.docente + "</td>";
                                            html = html + "<td>" + item.titulo + "</td>";
                                            html = html + "<td>" + item.tipo + "</td>";
                                            html = html + "<td>" + item.estado + "</td>";
                                            html = html + "<td>" + item.ps + "</td>";
                                            html = html + "<td>" + item.bo + "</td>";
                                            html = html + "<td>" + item.creado.date + "</td>";
                                            +"</tr>";
                                        });
                                        $("#tb2").html(html);
                                    } else {
                                        notify('Atención', 'No hay solicitudes para los parametros seleccionados', 'error');
                                    }
                                });
                            }
                            function pdf() {
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