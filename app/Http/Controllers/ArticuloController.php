<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Solicitud;
use App\Articulo;
use App\Auditoriasolicitud;
use App\Docente;
use App\Fechacierre;
use App\Http\Requests\ArticuloRequest;
use Illuminate\Support\Facades\Auth;

class ArticuloController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $u = Auth::user();
        $docente = Docente::where('numero_documento', $u->identificacion)->first();
        if ($docente == null) {
            flash("Usted  no es un Docente valido.")->warning();
            return redirect()->route('admin.solicitud');
        }
        $solicitudes = Solicitud::where([['tipo', 'ARTICULO'], ['docente_id', $docente->id]])->orWhere([['tipo', 'ARTICULO INDEXADO'], ['docente_id', $docente->id]])->get();
        //convertir articulo en coleccion
        $articulos = null;
        if (count($solicitudes) > 0) {
            foreach ($solicitudes as $s) {
                $articulos[] = Articulo::where('solicitud_id', $s->id)->first();
            }
        }
        return view('solicitud.articulos.articulos_docente.list')
                        ->with('location', 'solicitud')
                        ->with('articulos', $articulos)
                        ->with('docente', $docente);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexadmin() {
        $articulos = Articulo::all();
        return view('solicitud.articulos.articulos_admin.list')
                        ->with('location', 'solicitud')
                        ->with('articulos', $articulos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $fecha = Fechacierre::where('estado', 'ACTIVA')->first();
        if ($fecha != null) {
            $hoy = getdate();
            $a = $hoy["year"] . "-" . $hoy["mon"] . "-" . $hoy["mday"] . " " . $hoy["hours"] . ":" . $hoy["minutes"] . ":" . $hoy["seconds"];
            $h = strtotime($a);
            $fi = strtotime($fecha->fechainicio);
            $ff = strtotime($fecha->fechafin);
            if ($h >= $fi && $h <= $ff) {
                $u = Auth::user();
                $docente = Docente::where('numero_documento', $u->identificacion)->first();
                return view('solicitud.articulos.articulos_docente.create')
                                ->with('location', 'solicitud')
                                ->with('docente', $docente);
            } else {
                flash("No hay fecha disponible para subir su productividad académica. <strong>" . $fecha->fechainicio . " - " . $fecha->fechafin . "</strong>")->warning();
                return redirect()->route('articulo.index');
            }
        } else {
            flash("No hay fecha disponible para subir su productividad académica. <strong>" . $fecha->fechainicio . " - " . $fecha->fechafin . "</strong>")->warning();
            return redirect()->route('articulo.index');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticuloRequest $request) {
        $solicitud = new Solicitud($request->all());
        foreach ($solicitud->attributesToArray() as $key => $value) {
            $solicitud->$key = strtoupper($value);
        }
        $hoy = getdate();
        if ($request->indexada == "NO") {
            $solicitud->tipo = "ARTICULO INDEXADO";
            $tiene = Solicitud::where([['docente_id', $request->docente_id], ['tipo', "ARTICULO INDEXADO"]])->get();
            if (count($tiene) > 0) {
                $cont = 0;
                foreach ($tiene as $i) {
                    if ($i->fecha[0] . $i->fecha[1] . $i->fecha[2] . $i->fecha[3] == $hoy["year"]) {
                        $cont++;
                    }
                }
                if ($cont >= 5) {
                    flash("Usted ya cuenta con el maximo de bonificaciones para el año" . $hoy["year"] . ".")->warning();
                    return redirect()->route('articulo.index');
                }
            }
        } else {
            $solicitud->tipo = "ARTICULO";
        }
        if (isset($request->cvlac)) {
            $file = $request->file("cvlac");
            $name = "Cvlac_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
            $path = public_path() . "/docs/articulos/cvlac/";
            $file->move($path, $name);
            $solicitud->cvlac = $name;
        } else {
            $solicitud->cvlac = "NO";
        }
        if (isset($request->gruplac)) {
            $file = $request->file("gruplac");
            $name = "Gruplac_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
            $path = public_path() . "/docs/articulos/gruplac/";
            $file->move($path, $name);
            $solicitud->gruplac = $name;
        } else {
            $solicitud->gruplac = "NO";
        }
        $u = Auth::user();
        $solicitud->user_change = $u->identificacion;
        // $solicitud->fecha = $request->fechapublicacion;
        $idr = substr($u->identificacion, -3);
        $solicitud->radicado = $idr . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"];
        $aut = $request->num_autores;
        if ($request->indexada == "SI") {
            switch ($request->clasificacion) {
                case "A1":
                    if ($aut <= 3) {
                        $solicitud->puntos_aproximados_ps = 15;
                    }
                    if ($aut >= 4 && $aut <= 5) {
                        $solicitud->puntos_aproximados_ps = 15 / 2;
                    }
                    if ($aut >= 6) {
                        $solicitud->puntos_aproximados_ps = 15 / ($aut / 2);
                    }
                    $solicitud->puntos_aproximados_bo = 0;
                    break;
                case "A2":
                    if ($aut <= 3) {
                        $solicitud->puntos_aproximados_ps = 12;
                    }
                    if ($aut >= 4 && $aut <= 5) {
                        $solicitud->puntos_aproximados_ps = 12 / 2;
                    }
                    if ($aut >= 6) {
                        $solicitud->puntos_aproximados_ps = 12 / ($aut / 2);
                    }
                    $solicitud->puntos_aproximados_bo = 0;
                    break;
                case "B":
                    if ($aut <= 3) {
                        $solicitud->puntos_aproximados_ps = 8;
                    }
                    if ($aut >= 4 && $aut <= 5) {
                        $solicitud->puntos_aproximados_ps = 8 / 2;
                    }
                    if ($aut >= 6) {
                        $solicitud->puntos_aproximados_ps = 8 / ($aut / 2);
                    }
                    $solicitud->puntos_aproximados_bo = 0;
                    break;
                case "C":
                    if ($aut <= 3) {
                        $solicitud->puntos_aproximados_ps = 3;
                    }
                    if ($aut >= 4 && $aut <= 5) {
                        $solicitud->puntos_aproximados_ps = 3 / 2;
                    }
                    if ($aut >= 6) {
                        $solicitud->puntos_aproximados_ps = 3 / ($aut / 2);
                    }
                    $solicitud->puntos_aproximados_bo = 0;
                    break;
                default :$solicitud->puntos_ps = -1;
                    break;
            }
        } else {
            if ($aut <= 3) {
                $solicitud->puntos_aproximados_bo = 60;
            }
            if ($aut >= 4 && $aut <= 5) {
                $solicitud->puntos_aproximados_bo = 60 / 2;
            }
            if ($aut >= 6) {
                $solicitud->puntos_aproximados_bo = 60 / ($aut / 2);
            }
            $solicitud->puntos_aproximados_ps = 0;
        }
        $result = $solicitud->save();
        if ($result) {
            $articulo = new Articulo($request->all());
            foreach ($articulo->attributesToArray() as $key => $value) {
                $articulo->$key = strtoupper($value);
            }
            if ($request->indexada == "NO") {
                $articulo->clasificacion = "SIN CATEGORIA";
            }
            if (isset($request->articulo_pdf)) {
                $file = $request->file("articulo_pdf");
                $name = "Articulo_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
                $path = public_path() . "/docs/articulos/pdf/";
                $file->move($path, $name);
                $articulo->articulo_pdf = $name;
            } else {
                $articulo->articulo_pdf = "NO";
            }
            if (isset($request->publindex)) {
                $file = $request->file("publindex");
                $name = "Publindex_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
                $path = public_path() . "/docs/articulos/publindex/";
                $file->move($path, $name);
                $articulo->publindex = $name;
            } else {
                $articulo->publindex = "NO";
            }
            $articulo->solicitud_id = $solicitud->id;
            $articulo->user_change = $u->identificacion;
            $result2 = $articulo->save();
            if ($result2) {
                $aud = new Auditoriasolicitud();
                $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $aud->operacion = "INSERTAR";
                $str = "CREACIÓN DE SOLICTUD TIPO ARTICULO. DATOS: ";
                foreach ($articulo->attributesToArray() as $key => $value) {
                    $str = $str . ", " . $key . ": " . $value;
                }
                $aud->detalles = $str;
                $aud->save();
                flash("La Productividad Académica <strong>" . $solicitud->titulo . "</strong> fue almacenada de forma exitosa!")->success();
                return redirect()->route('articulo.index');
            } else {
                $solicitud->delete();
                flash("La Productividad Académica <strong>" . $solicitud->titulo . "</strong> no pudo ser almacenada. Error: " . $result)->error();
                return redirect()->route('articulo.index');
            }
        } else {
            flash("La Productividad Académica <strong>" . $solicitud->titulo . "</strong> no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('articulo.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $articulo = Articulo::find($id);
        $solicitud = $articulo->solicitud;
        $nombre = $solicitud->docente->primer_nombre . " " . $solicitud->docente->segundo_nombre . " " . $solicitud->docente->primer_apellido . " " . $solicitud->docente->segundo_apellido;
        $docente = $solicitud->docente;
        return view('solicitud.articulos.articulos_docente.show')
                        ->with('location', 'solicitud')
                        ->with('articulo', $articulo)
                        ->with('nombre', $nombre)
                        ->with('docente', $docente)
                        ->with('solicitud', $solicitud);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $articulo = Articulo::find($id);
        $solicitud = $articulo->solicitud;
        $fecha = Fechacierre::where('estado', 'ACTIVA')->first();
        if ($fecha != null) {
            $hoy = getdate();
            $a = $hoy["year"] . "-" . $hoy["mon"] . "-" . $hoy["mday"] . " " . $hoy["hours"] . ":" . $hoy["minutes"] . ":" . $hoy["seconds"];
            $h = strtotime($a);
            $fi = strtotime($fecha->fechainicio);
            $ff = strtotime($fecha->fechafin);
            if ($h >= $fi && $h <= $ff) {
                $u = Auth::user();
                $docente = Docente::where('numero_documento', $u->identificacion)->first();
                return view('solicitud.articulos.articulos_docente.edit')
                                ->with('location', 'solicitud')
                                ->with('docente', $docente)
                                ->with('articulo', $articulo);
            } else {
                flash("No hay fecha disponible para modificar su productividad académica. <strong>" . $fecha->fechainicio . " - " . $fecha->fechafin . "</strong>")->warning();
                return redirect()->route('articulo.index');
            }
        } else {
            flash("No hay fecha disponible para modificar su productividad académica. <strong>" . $fecha->fechainicio . " - " . $fecha->fechafin . "</strong>")->warning();
            return redirect()->route('articulo.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $articulo = Articulo::find($id);
        $solicitud = Solicitud::find($articulo->solicitud_id);
        $m = new Solicitud($solicitud->attributesToArray());
        foreach ($solicitud->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $solicitud->$key = strtoupper($request->$key);
            }
        }
        $hoy = getdate();
        if ($request->indexada == "SI") {
            $solicitud->tipo = "ARTICULO INDEXADO";
            $tiene = Solicitud::where([['docente_id', $request->docente_id], ['tipo', "ARTICULO INDEXADO"]])->get();
            if (count($tiene) > 0) {
                $cont = 0;
                foreach ($tiene as $i) {
                    if ($i->fecha[0] . $i->fecha[1] . $i->fecha[2] . $i->fecha[3] == $hoy["year"]) {
                        $cont++;
                    }
                }
                if ($cont >= 3) {
                    flash("Usted ya cuenta con el maximo de bonificaciones para el año" . $hoy["year"] . ".")->warning();
                    return redirect()->route('articulo.index');
                }
            }
        } else {
            $solicitud->tipo = "ARTICULO";
        }
        if (isset($request->cvlac)) {
            if (unlink(public_path() . "/docs/articulos/cvlac/" . $m->cvlac)) {
                $file = $request->file("cvlac");
                $name = "Cvlac_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
                $path = public_path() . "/docs/articulos/cvlac/";
                $file->move($path, $name);
                $solicitud->cvlac = $name;
            }
        }
        if (isset($request->gruplac)) {
            if (unlink(public_path() . "/docs/articulos/gruplac/" . $m->gruplac)) {
                $file = $request->file("gruplac");
                $name = "Gruplac_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
                $path = public_path() . "/docs/articulos/gruplac/";
                $file->move($path, $name);
                $solicitud->gruplac = $name;
            }
        }
        $u = Auth::user();
        $solicitud->user_change = $u->identificacion;
        $aut = $request->num_autores;
        if ($request->indexada == "SI") {
            switch ($request->clasificacion) {
                case "A1":
                    if ($aut <= 3) {
                        $solicitud->puntos_aproximados_ps = 15;
                    }
                    if ($aut >= 4 && $aut <= 5) {
                        $solicitud->puntos_aproximados_ps = 15 / 2;
                    }
                    if ($aut >= 6) {
                        $solicitud->puntos_aproximados_ps = 15 / ($aut / 2);
                    }
                    $solicitud->puntos_aproximados_bo = 0;
                    break;
                case "A2":
                    if ($aut <= 3) {
                        $solicitud->puntos_aproximados_ps = 12;
                    }
                    if ($aut >= 4 && $aut <= 5) {
                        $solicitud->puntos_aproximados_ps = 12 / 2;
                    }
                    if ($aut >= 6) {
                        $solicitud->puntos_aproximados_ps = 12 / ($aut / 2);
                    }
                    $solicitud->puntos_aproximados_bo = 0;
                    break;
                case "B":
                    if ($aut <= 3) {
                        $solicitud->puntos_aproximados_ps = 8;
                    }
                    if ($aut >= 4 && $aut <= 5) {
                        $solicitud->puntos_aproximados_ps = 8 / 2;
                    }
                    if ($aut >= 6) {
                        $solicitud->puntos_aproximados_ps = 8 / ($aut / 2);
                    }
                    $solicitud->puntos_aproximados_bo = 0;
                    break;
                case "C":
                    if ($aut <= 3) {
                        $solicitud->puntos_aproximados_ps = 3;
                    }
                    if ($aut >= 4 && $aut <= 5) {
                        $solicitud->puntos_aproximados_ps = 3 / 2;
                    }
                    if ($aut >= 6) {
                        $solicitud->puntos_aproximados_ps = 3 / ($aut / 2);
                    }
                    $solicitud->puntos_aproximados_bo = 0;
                    break;
                default :$solicitud->puntos_ps = -1;
                    break;
            }
        } else {
            if ($aut <= 3) {
                $solicitud->puntos_aproximados_bo = 60;
            }
            if ($aut >= 4 && $aut <= 5) {
                $solicitud->puntos_aproximados_bo = 60 / 2;
            }
            if ($aut >= 6) {
                $solicitud->puntos_aproximados_bo = 60 / ($aut / 2);
            }
            $solicitud->puntos_aproximados_ps = 0;
            $articulo->clasificacion = "SIN CATEGORIA";
        }
        $result = $solicitud->save();
        if ($result) {
            $a = new Articulo($articulo->attributesToArray());
            foreach ($articulo->attributesToArray() as $key => $value) {
                if (isset($request->$key)) {
                    $articulo->$key = strtoupper($request->$key);
                }
            }
            if (isset($request->articulo_pdf)) {
                if (unlink(public_path() . "/docs/articulos/pdf/" . $a->articulo_pdf)) {
                    $file = $request->file("articulo_pdf");
                    $name = "Articulo_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
                    $path = public_path() . "/docs/articulos/pdf/";
                    $file->move($path, $name);
                    $articulo->articulo_pdf = $name;
                }
            }
            if (isset($request->publindex)) {
                if (unlink(public_path() . "/docs/articulos/publindex/" . $a->publindex)) {
                    $file = $request->file("publindex");
                    $name = "Publindex_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
                    $path = public_path() . "/docs/articulos/publindex/";
                    $file->move($path, $name);
                    $articulo->publindex = $name;
                }
            }
            $articulo->user_change = $u->identificacion;
            $result2 = $articulo->save();
            if ($result2) {
                $aud = new Auditoriasolicitud();
                $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $aud->operacion = "ACTUALIZAR DATOS";
                $str = "EDICION DE ARTICULO. DATOS NUEVOS: ";
                $str2 = " DATOS ANTIGUOS: ";
                foreach ($a->attributesToArray() as $key => $value) {
                    $str2 = $str2 . ", " . $key . ": " . $value;
                }
                foreach ($articulo->attributesToArray() as $key => $value) {
                    $str = $str . ", " . $key . ": " . $value;
                }
                $aud->detalles = $str . " - " . $str2;
                $aud->save();
                flash("El Articulo <strong>" . $articulo->solicitud->titulo . "</strong> fue modificado de forma exitosa!")->success();
                return redirect()->route('articulo.index');
            } else {
                $solicitud = $m;
                $articulo = $a;
                $solicitud->save();
                $articulo->save();
                flash("El Articulo <strong>" . $articulo->solicitud->titulo . "</strong> no pudo ser modificado. Error: " . $result)->error();
                return redirect()->route('articulo.index');
            }
        } else {
            flash("El Articulo <strong>" . $articulo->solicitud->titulo . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('articulo.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $articulo = Articulo::find($id);
        $solicitud = $articulo->solicitud;
        $e = $solicitud->gruplac;
        $b = $solicitud->cvlac;
        $c = $articulo->articulo_pdf;
        $d = $articulo->publindex;
        $fecha = Fechacierre::where('estado', 'ACTIVA')->first();
        if ($fecha != null) {
            $hoy = getdate();
            $a = $hoy["year"] . "-" . $hoy["mon"] . "-" . $hoy["mday"] . " " . $hoy["hours"] . ":" . $hoy["minutes"] . ":" . $hoy["seconds"];
            $h = strtotime($a);
            $fi = strtotime($fecha->fechainicio);
            $ff = strtotime($fecha->fechafin);
            if ($h >= $fi && $h <= $ff) {
                $result = $solicitud->delete();
                if ($result) {
                    unlink(public_path() . "/docs/articulos/cvlac/" . $b);
                    unlink(public_path() . "/docs/articulos/gruplac/" . $e);
                    unlink(public_path() . "/docs/articulos/publindex/" . $d);
                    unlink(public_path() . "/docs/articulos/pdf/" . $c);
                    $aud = new Auditoriasolicitud();
                    $u = Auth::user();
                    $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                    $aud->operacion = "ELIMINAR";
                    $str = "ELIMINACIÓN DE SOLICITUD DE ARTICULO. DATOS ELIMINADOS: ";
                    foreach ($solicitud->attributesToArray() as $key => $value) {
                        $str = $str . ", " . $key . ": " . $value;
                    }
                    $aud->detalles = $str;
                    $aud->save();
                    flash("La Productividad Académica <strong>" . $solicitud->titulo . "</strong> fue eliminada de forma exitosa!")->success();
                    return redirect()->route('articulo.index');
                } else {
                    flash("La Productividad Académica <strong>" . $solicitud->titulo . "</strong> no pudo ser eliminada. Error: " . $result)->error();
                    return redirect()->route('articulo.index');
                }
            } else {
                flash("No hay fecha disponible para eliminar su productividad académica.<strong>" . $fecha->fechainicio . " - " . $fecha->fechafin . "</strong>")->warning();
                return redirect()->route('articulo.index');
            }
        } else {
            flash("No hay fecha disponible para eliminar su productividad académica. <strong>" . $fecha->fechainicio . " - " . $fecha->fechafin . "</strong>")->warning();
            return redirect()->route('articulo.index');
        }
    }

    /**
     * Evalua una solicitud de tipo artículo.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function evaluar($id) {
        $articulo = Articulo::find($id);
        $solicitud = $articulo->solicitud;
        $fecha = Fechacierre::where('estado', 'ACTIVA')->first();
        if ($fecha != null) {
            $hoy = getdate();
            $a = $hoy["year"] . "-" . $hoy["mon"] . "-" . $hoy["mday"] . " " . $hoy["hours"] . ":" . $hoy["minutes"] . ":" . $hoy["seconds"];
            $h = strtotime($a);
            $fi = strtotime($fecha->fechainicio);
            $ff = strtotime($fecha->fechafin);
            if ($h > $fi) {
                if ($solicitud->estado != "APROBADA" && $solicitud->estado != "RECHAZADA") {
                    $docente = Docente::find($solicitud->docente_id);
                    return view('solicitud.articulos.articulos_admin.evaluar')
                                    ->with('location', 'solicitud')
                                    ->with('solicitud', $solicitud)
                                    ->with('articulo', $articulo)
                                    ->with('docente', $docente);
                } else {
                    flash("La Productividad seleccionada ya fue evaluada.")->warning();
                    return redirect()->route('articulo.indexadmin');
                }
            } else {
                flash("No hay fecha disponible para evaluar productividad académica. <strong>" . $fecha->fechainicio . " - " . $fecha->fechafin . "</strong>")->warning();
                return redirect()->route('articulo.indexadmin');
            }
        } else {
            flash("No hay fecha disponible para evaluar productividad académica. <strong>" . $fecha->fechainicio . " - " . $fecha->fechafin . "</strong>")->warning();
            return redirect()->route('articulo.indexadmin');
        }
    }

    public function calificar(Request $request) {
        $hoy = getdate();
        $articulo = Articulo::find($request->articulo_id);
        $solicitud = Solicitud::find($request->solicitud_id);
        $solicitud->estado = $request->estado;
        $solicitud->observacion = strtoupper($request->observacion);
        $solicitud->puntos_ps = $request->puntos_ps;
        $solicitud->puntos_bo = $request->puntos_bo;
        $solicitud->fecha = $hoy["year"] . "-" . $hoy["mon"] . "-" . $hoy["mday"];
        $result = $solicitud->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriasolicitud();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "EVALUAR";
            $str = "ASIGNACIÓN DE PUNTOS A SOLICTUD TIPO ARTICULO. DATOS: ";
            foreach ($articulo->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La Productividad Académica <strong>" . $solicitud->titulo . "</strong> fue evaluada de forma exitosa!")->success();
            return redirect()->route('articulo.indexadmin');
        } else {
            flash("La Productividad Académica <strong>" . $solicitud->titulo . "</strong> no pudo ser evaluada. Error: " . $result)->error();
            return redirect()->route('articulo.index');
        }
    }

}
