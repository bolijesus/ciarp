<?php

namespace App\Http\Controllers;

use App\Ponencia;
use App\Solicitud;
use App\Docente;
use App\Fechacierre;
use App\Auditoriasolicitud;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PonenciaRequest;
use Illuminate\Http\Request;

class PonenciaController extends Controller {

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
        $solicitudes = Solicitud::where([['tipo', 'PONENCIA'], ['docente_id', $docente->id]])->get();
        //convertir articulo en coleccion
        $ponencias = null;
        if (count($solicitudes) > 0) {
            foreach ($solicitudes as $s) {
                $ponencias[] = Ponencia::where('solicitud_id', $s->id)->first();
            }
        }
        return view('solicitud.ponencias.ponencia_docente.list')
                        ->with('location', 'solicitud')
                        ->with('ponencias', $ponencias);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexadmin() {
        $ponencias = Ponencia::all();
        return view('solicitud.ponencias.ponencia_admin.list')
                        ->with('location', 'solicitud')
                        ->with('ponencias', $ponencias);
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
                return view('solicitud.ponencias.ponencia_docente.create')
                                ->with('location', 'solicitud')
                                ->with('docente', $docente);
            } else {
                flash("No hay fecha disponible para subir su productividad académica. <strong>" . $fecha->fechainicio . " - " . $fecha->fechafin . "</strong>")->warning();
                return redirect()->route('ponencia.index');
            }
        } else {
            flash("No hay fecha disponible para subir su productividad académica. <strong>" . $fecha->fechainicio . " - " . $fecha->fechafin . "</strong>")->warning();
            return redirect()->route('ponencia.index');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $solicitud = new Solicitud($request->all());
        foreach ($solicitud->attributesToArray() as $key => $value) {
            $solicitud->$key = strtoupper($value);
        }
        $hoy = getdate();
        $solicitud->tipo = "PONENCIA";
        $tiene = Solicitud::where([['docente_id', $request->docente_id], ['tipo', "PONENCIA"]])->get();
        if (count($tiene) > 0) {
            $cont = 0;
            foreach ($tiene as $i) {
                if ($i->fecha[0] . $i->fecha[1] . $i->fecha[2] . $i->fecha[3] == $hoy["year"]) {
                    $cont++;
                }
            }
            if ($cont >= 3) {
                flash("Usted ya cuenta con el maximo de bonificaciones para el año" . $hoy["year"] . ".")->warning();
                return redirect()->route('ponencia.index');
            }
        }
        if (isset($request->cvlac)) {
            $file = $request->file("cvlac");
            $name = "Cvlac_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
            $path = public_path() . "/docs/ponencia/cvlac/";
            $file->move($path, $name);
            $solicitud->cvlac = $name;
        } else {
            $solicitud->cvlac = "NO";
        }
        if (isset($request->gruplac)) {
            $file = $request->file("gruplac");
            $name = "Gruplac_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
            $path = public_path() . "/docs/ponencia/gruplac/";
            $file->move($path, $name);
            $solicitud->gruplac = $name;
        } else {
            $solicitud->gruplac = "NO";
        }
        $u = Auth::user();
        $solicitud->user_change = $u->identificacion;
        $idr = substr($u->identificacion, -3);
        $solicitud->radicado = $idr . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"];
        $aut = $request->num_autores;
        switch ($request->tipo) {
            case "INTERNACIONAL":if ($aut <= 3) {
                    $solicitud->puntos_aproximados_bo = 84;
                }
                if ($aut >= 4 && $aut <= 5) {
                    $solicitud->puntos_aproximados_bo = 84 / 2;
                }
                if ($aut >= 6) {
                    $solicitud->puntos_aproximados_bo = 84 / ($aut / 2);
                }
                break;
            case "NACIONAL":if ($aut <= 3) {
                    $solicitud->puntos_aproximados_bo = 48;
                }
                if ($aut >= 4 && $aut <= 5) {
                    $solicitud->puntos_aproximados_bo = 48 / 2;
                }
                if ($aut >= 6) {
                    $solicitud->puntos_aproximados_bo = 48 / ($aut / 2);
                }
                break;
            case "REGIONAL":if ($aut <= 3) {
                    $solicitud->puntos_aproximados_bo = 24;
                }
                if ($aut >= 4 && $aut <= 5) {
                    $solicitud->puntos_aproximados_bo = 24 / 2;
                }
                if ($aut >= 6) {
                    $solicitud->puntos_aproximados_bo = 24 / ($aut / 2);
                }
                break;
            default :$solicitud->puntos_bo = -1;
                break;
        }
        $solicitud->puntos_aproximados_ps = 0;
        $solicitud->puntos_ps = 0;
        $result = $solicitud->save();
        if ($result) {
            $ponencia = new Ponencia($request->all());
            foreach ($ponencia->attributesToArray() as $key => $value) {
                $ponencia->$key = strtoupper($value);
            }
            if (isset($request->archivo_memorias)) {
                $file = $request->file("archivo_memorias");
                $name = "Memoria_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
                $path = public_path() . "/docs/ponencia/memorias/";
                $file->move($path, $name);
                $ponencia->archivo_memorias = $name;
            } else {
                $ponencia->archivo_memorias = "NO";
            }
            if (isset($request->cert_ponente)) {
                $file = $request->file("cert_ponente");
                $name = "Certificado_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
                $path = public_path() . "/docs/ponencia/cert_ponente/";
                $file->move($path, $name);
                $ponencia->cert_ponente = $name;
            } else {
                $ponencia->cert_ponente = "NO";
            }
            $ponencia->solicitud_id = $solicitud->id;
            $ponencia->user_change = $u->identificacion;
            $result2 = $ponencia->save();
            if ($result2) {
                $aud = new Auditoriasolicitud();
                $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $aud->operacion = "INSERTAR";
                $str = "CREACIÓN DE SOLICTUD TIPO PONENCIA. DATOS: ";
                foreach ($ponencia->attributesToArray() as $key => $value) {
                    $str = $str . ", " . $key . ": " . $value;
                }
                $aud->detalles = $str;
                $aud->save();
                flash("La Productividad Académica <strong>" . $solicitud->titulo . "</strong> fue almacenada de forma exitosa!")->success();
                return redirect()->route('ponencia.index');
            } else {
                $solicitud->delete();
                flash("La Productividad Académica <strong>" . $solicitud->titulo . "</strong> no pudo ser almacenada. Error: " . $result)->error();
                return redirect()->route('ponencia.index');
            }
        } else {
            flash("La Productividad Académica <strong>" . $solicitud->titulo . "</strong> no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('ponencia.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $ponencia = Ponencia::find($id);
        $solicitud = $ponencia->solicitud;
        $nombre = $solicitud->docente->primer_nombre . " " . $solicitud->docente->segundo_nombre . " " . $solicitud->docente->primer_apellido . " " . $solicitud->docente->segundo_apellido;
        $docente = $solicitud->docente;
        return view('solicitud.ponencias.ponencia_docente.show')
                        ->with('location', 'solicitud')
                        ->with('ponencia', $ponencia)
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
        $ponencia = Ponencia::find($id);
        $solicitud = $ponencia->solicitud;
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
                return view('solicitud.ponencias.ponencia_docente.edit')
                                ->with('location', 'solicitud')
                                ->with('docente', $docente)
                                ->with('ponencia', $ponencia);
            } else {
                flash("No hay fecha disponible para modificar su productividad académica. <strong>" . $fecha->fechainicio . " - " . $fecha->fechafin . "</strong>")->warning();
                return redirect()->route('ponencia.index');
            }
        } else {
            flash("No hay fecha disponible para modificar su productividad académica. <strong>" . $fecha->fechainicio . " - " . $fecha->fechafin . "</strong>")->warning();
            return redirect()->route('ponencia.index');
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
        $ponencia = Ponencia::find($id);
        $solicitud = Solicitud::find($ponencia->solicitud_id);
        $m = new Solicitud($solicitud->attributesToArray());
        foreach ($solicitud->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $solicitud->$key = strtoupper($request->$key);
            }
        }
        $solicitud->tipo = "PONENCIA";
        $hoy = getdate();
        if (isset($request->cvlac)) {
            if (unlink(public_path() . "/docs/ponencia/cvlac/" . $m->cvlac)) {
                $file = $request->file("cvlac");
                $name = "Cvlac_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
                $path = public_path() . "/docs/ponencia/cvlac/";
                $file->move($path, $name);
                $solicitud->cvlac = $name;
            }
        }
        if (isset($request->gruplac)) {
            if (unlink(public_path() . "/docs/ponencia/gruplac/" . $m->gruplac)) {
                $file = $request->file("gruplac");
                $name = "Gruplac_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
                $path = public_path() . "/docs/ponencia/gruplac/";
                $file->move($path, $name);
                $solicitud->gruplac = $name;
            }
        }
        $u = Auth::user();
        $solicitud->user_change = $u->identificacion;
        $aut = $request->num_autores;
        switch ($request->tipo) {
            case "INTERNACIONAL":if ($aut <= 3) {
                    $solicitud->puntos_aproximados_bo = 84;
                }
                if ($aut >= 4 && $aut <= 5) {
                    $solicitud->puntos_aproximados_bo = 84 / 2;
                }
                if ($aut >= 6) {
                    $solicitud->puntos_aproximados_bo = 84 / ($aut / 2);
                }
                break;
            case "NACIONAL":if ($aut <= 3) {
                    $solicitud->puntos_aproximados_bo = 48;
                }
                if ($aut >= 4 && $aut <= 5) {
                    $solicitud->puntos_aproximados_bo = 48 / 2;
                }
                if ($aut >= 6) {
                    $solicitud->puntos_aproximados_bo = 48 / ($aut / 2);
                }
                break;
            case "REGIONAL":if ($aut <= 3) {
                    $solicitud->puntos_aproximados_bo = 24;
                }
                if ($aut >= 4 && $aut <= 5) {
                    $solicitud->puntos_aproximados_bo = 24 / 2;
                }
                if ($aut >= 6) {
                    $solicitud->puntos_aproximados_bo = 24 / ($aut / 2);
                }
                break;
            default :$solicitud->puntos_bo = -1;
                break;
        }
        $result = $solicitud->save();
        if ($result) {
            $a = new Ponencia($ponencia->attributesToArray());
            foreach ($ponencia->attributesToArray() as $key => $value) {
                if (isset($request->$key)) {
                    $ponencia->$key = strtoupper($request->$key);
                }
            }
            if (isset($request->archivo_memorias)) {
                if (unlink(public_path() . "/docs/ponencia/memorias/" . $a->archivo_memorias)) {
                    $file = $request->file("archivo_memorias");
                    $name = "Memoria_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
                    $path = public_path() . "/docs/ponencia/memorias/";
                    $file->move($path, $name);
                    $ponencia->archivo_memorias = $name;
                }
            }
            if (isset($request->cert_ponente)) {
                if (unlink(public_path() . "/docs/ponencia/cert_ponente/" . $a->cert_ponente)) {
                    $file = $request->file("cert_ponente");
                    $name = "Certificado_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
                    $path = public_path() . "/docs/ponencia/cert_ponente/";
                    $file->move($path, $name);
                    $ponencia->cert_ponente = $name;
                }
            }
            $ponencia->user_change = $u->identificacion;
            $result2 = $ponencia->save();
            if ($result2) {
                $aud = new Auditoriasolicitud();
                $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $aud->operacion = "ACTUALIZAR DATOS";
                $str = "EDICION DE PONENCIA. DATOS NUEVOS: ";
                $str2 = " DATOS ANTIGUOS: ";
                foreach ($a->attributesToArray() as $key => $value) {
                    $str2 = $str2 . ", " . $key . ": " . $value;
                }
                foreach ($ponencia->attributesToArray() as $key => $value) {
                    $str = $str . ", " . $key . ": " . $value;
                }
                $aud->detalles = $str . " - " . $str2;
                $aud->save();
                flash("La Ponencia <strong>" . $ponencia->solicitud->titulo . "</strong> fue modificada de forma exitosa!")->success();
                return redirect()->route('ponencia.index');
            } else {
                $solicitud = $m;
                $ponencia = $a;
                $solicitud->save();
                $ponencia->save();
                flash("La Ponencia <strong>" . $ponencia->solicitud->titulo . "</strong> no pudo ser modificada. Error: " . $result)->error();
                return redirect()->route('ponencia.index');
            }
        } else {
            flash("La Ponencia <strong>" . $ponencia->solicitud->titulo . "</strong> no pudo ser modificada. Error: " . $result)->error();
            return redirect()->route('ponencia.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $ponencia = Ponencia::find($id);
        $solicitud = $ponencia->solicitud;
        $e = $solicitud->gruplac;
        $b = $solicitud->cvlac;
        $c = $ponencia->archivo_memorias;
        $d = $ponencia->cert_ponente;
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
                    unlink(public_path() . "/docs/ponencia/cvlac/" . $b);
                    unlink(public_path() . "/docs/ponencia/gruplac/" . $e);
                    unlink(public_path() . "/docs/ponencia/memorias/" . $c);
                    unlink(public_path() . "/docs/ponencia/cert_ponente/" . $d);
                    $aud = new Auditoriasolicitud();
                    $u = Auth::user();
                    $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                    $aud->operacion = "ELIMINAR";
                    $str = "ELIMINACIÓN DE SOLICITUD DE PONENCIA. DATOS ELIMINADOS: ";
                    foreach ($solicitud->attributesToArray() as $key => $value) {
                        $str = $str . ", " . $key . ": " . $value;
                    }
                    $aud->detalles = $str;
                    $aud->save();
                    flash("La Productividad Académica <strong>" . $solicitud->titulo . "</strong> fue eliminada de forma exitosa!")->success();
                    return redirect()->route('ponencia.index');
                } else {
                    flash("La Productividad Académica <strong>" . $solicitud->titulo . "</strong> no pudo ser eliminada. Error: " . $result)->error();
                    return redirect()->route('ponencia.index');
                }
            } else {
                flash("No hay fecha disponible para eliminar su productividad académica.<strong>" . $fecha->fechainicio . " - " . $fecha->fechafin . "</strong>")->warning();
                return redirect()->route('ponencia.index');
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
        $ponencia = Ponencia::find($id);
        $solicitud = $ponencia->solicitud;
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
                    return view('solicitud.ponencias.ponencia_admin.evaluar')
                                    ->with('location', 'solicitud')
                                    ->with('solicitud', $solicitud)
                                    ->with('ponencia', $ponencia)
                                    ->with('docente', $docente);
                } else {
                    flash("La Productividad seleccionada ya fue evaluada.")->warning();
                    return redirect()->route('ponencia.indexadmin');
                }
            } else {
                flash("No hay fecha disponible para evaluar productividad académica. <strong>" . $fecha->fechainicio . " - " . $fecha->fechafin . "</strong>")->warning();
                return redirect()->route('ponencia.indexadmin');
            }
        } else {
            flash("No hay fecha disponible para evaluar productividad académica. <strong>" . $fecha->fechainicio . " - " . $fecha->fechafin . "</strong>")->warning();
            return redirect()->route('ponencia.indexadmin');
        }
    }

    public function calificar(Request $request) {
        $hoy = getdate();
        $ponencia = Ponencia::find($request->ponencia_id);
        $solicitud = Solicitud::find($request->solicitud_id);
        $solicitud->estado = $request->estado;
        $solicitud->observacion = strtoupper($request->observacion);
        $solicitud->puntos_ps = 0;
        $solicitud->puntos_bo = $request->puntos_bo;
        $solicitud->fecha = $hoy["year"] . "-" . $hoy["mon"] . "-" . $hoy["mday"];
        $result = $solicitud->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriasolicitud();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "EVALUAR";
            $str = "ASIGNACIÓN DE PUNTOS A SOLICTUD TIPO PONENCIA. DATOS: ";
            foreach ($ponencia->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La Productividad Académica <strong>" . $solicitud->titulo . "</strong> fue evaluada de forma exitosa!")->success();
            return redirect()->route('ponencia.indexadmin');
        } else {
            flash("La Productividad Académica <strong>" . $solicitud->titulo . "</strong> no pudo ser evaluada. Error: " . $result)->error();
            return redirect()->route('ponencia.index');
        }
    }

}
