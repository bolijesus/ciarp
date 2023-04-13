<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Solicitud;
use App\Docente;
use App\Articulo;
use App\Libro;
use App\Software;
use App\Ponencia;
use App\Fechacierre;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller {

    public function acta() {
        return view('reportes.acta')
                        ->with('location', 'reportes');
    }

    public function acta_pdf($anio, $per) {
        if ($per == 1) {
            $fi = $anio . "-01-01";
            $ff = $anio . "-06-30";
        } else {
            $fi = $anio . "-07-01";
            $ff = $anio . "-12-31";
        }
        $solicitudes = DB::table('solicituds')->whereBetween('fecha', [$fi, $ff])->get();
        $a = null;
        if ($solicitudes !== null) {
            foreach ($solicitudes as $value) {
                $a[] = Solicitud::find($value->id);
            }
        }
        if ($a != null) {
            $sol = null;
            $cont = 1;
            foreach ($a as $i) {
                if ($i->tipo == "LIBRO") {
                    $pro = Libro::where('solicitud_id', $i->id)->first();
                    $fechapubl = $pro->fecha_publicacion;
                } else if ($i->tipo == "SOFTWARE") {
                    $pro = Software::where('solicitud_id', $i->id)->first();
                    $fechapubl = " ";
                } else if ($i->tipo == "PONENCIA") {
                    $pro = Ponencia::where('solicitud_id', $i->id)->first();
                    $fechapubl = $pro->fecha_evento;
                } else {
                    $pro = Articulo::where('solicitud_id', $i->id)->first();
                    $fechapubl = $pro->fechapublicacion;
                }
                if ($i->tipo == "PONENCIA" || $i->tipo == "ARTICULO INDEXADO") {
                    $puntos = $i->puntos_bo;
                } else {
                    $puntos = $i->puntos_ps;
                }
                $obj["num"] = $cont++;
                $obj["docente"] = $i->docente->primer_nombre . " " . $i->docente->segundo_nombre . " " . $i->docente->primer_apellido . " " . $i->docente->segundo_apellido;
                $obj["fundamento"] = $i->tipo . " TITULADO: " . $i->titulo . " FECHA DE PUBLICACIÓN: " . $fechapubl . " AUTORES: " . $i->num_autores;
                $obj["puntos"] = $puntos;
                $sol[] = $obj;
            }
            return json_encode($sol);
        } else {
            return "null";
        }
    }

    public function productividad() {
        return view('reportes.productividad')
                        ->with('location', 'reportes');
    }

    public function getSolicitudes($estado, $fi, $ff, $tipo, $documento) {
        if ($documento != "null") {
            $docente = Docente::where('numero_documento', $documento)->first();
            if ($docente != null) {
                $b = DB::table('solicituds')->whereBetween('created_at', [$fi, $ff])->where('docente_id', $docente->id)->get();
            } else {
                return "null";
            }
        }
        $b = DB::table('solicituds')->whereBetween('created_at', [$fi, $ff])->get();
        $a = null;
        if ($b != null) {
            foreach ($b as $value) {
                if ($estado != "TODO") {
                    if ($value->estado == $estado) {
                        if ($tipo != "TODO") {
                            if ($value->tipo == $tipo) {
                                $o = Solicitud::find($value->id);
                                $a[] = $o;
                            }
                        } else {
                            $o = Solicitud::find($value->id);
                            $a[] = $o;
                        }
                    }
                } else {
                    if ($tipo != "TODO") {
                        if ($value->tipo == $tipo) {
                            $o = Solicitud::find($value->id);
                            $a[] = $o;
                        }
                    } else {
                        $o = Solicitud::find($value->id);
                        $a[] = $o;
                    }
                }
            }
            $start = strtotime($fi);
            $end = strtotime($ff);
            $total = null;
            while ($start < $end) {
                $to = [
                    'ps' => 0,
                    'bo' => 0
                ];
                $ps = $bo = 0;
                foreach ($a as $i) {
                    $l = date("Y-m-d", $start);
                    $c = explode("-", $l);
                    $k = explode("-", $i->fecha);
                    if ($i->fecha != null) {
                        if ($k[1] == $c[1]) {
                            $to["ps"] = $to["ps"] + $i->puntos_ps;
                            $to["bo"] = $to["bo"] + $i->puntos_bo;
                        }
                    }
                }
                $total[$l] = $to;
                $m[] = strftime('%b %Y', $start);
                $start = strtotime("+1 month", $start);
            }
            if ($total != null) {
                $puntos_ps = $puntos_bo = null;
                foreach ($total as $key => $value) {
                    $puntos_ps[] = $value["ps"];
                    $puntos_bo[] = $value["bo"];
                }
            }
            if ($a != null) {
                $sol = null;
                foreach ($a as $item) {
                    $obj["id"] = $item->id;
                    $obj["radicado"] = $item->radicado;
                    $obj["docente"] = $item->docente->primer_nombre . " - " . $item->docente->segundo_nombre . " " . $item->docente->primer_apellido . " " . $item->docente->segundo_apellido;
                    $obj["titulo"] = $item->titulo;
                    $obj["tipo"] = $item->tipo;
                    $obj["estado"] = $item->estado;
                    $obj["ps"] = $item->puntos_ps;
                    $obj["bo"] = $item->puntos_bo;
                    $obj["creado"] = $item->created_at;
                    $sol['data'][] = $obj;
                }
                $sol["meses"] = $m;
                $sol["ps"] = $puntos_ps;
                $sol["bo"] = $puntos_bo;
                return json_encode($sol);
            } else {
                return "null";
            }
        }
    }

}
