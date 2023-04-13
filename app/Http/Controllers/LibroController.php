<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libro;
use App\Solicitud;
use App\Auditoriasolicitud;
use App\Docente;
use App\Fechacierre;
use App\Http\Requests\LibroRequest;
use Illuminate\Support\Facades\Auth;

class LibroController extends Controller {

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
        $solicitudes = Solicitud::where([['tipo', 'LIBRO'], ['docente_id', $docente->id]])->get();
        //convertir articulo en coleccion
        $libros = null;
        if (count($solicitudes) > 0) {
            foreach ($solicitudes as $s) {
                $libros[] = Libro::where('solicitud_id', $s->id)->first();
            }
        }
        return view('solicitud.libros.libros_docente.list')
                        ->with('location', 'solicitud')
                        ->with('docente', $docente)
                        ->with('libros', $libros);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexadmin() {
        $libros = Libro::all();
        return view('solicitud.libros.libros_admin.list')
                        ->with('location', 'solicitud')
                        ->with('libros', $libros);
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
                return view('solicitud.libros.libros_docente.create')
                                ->with('location', 'solicitud')
                                ->with('docente', $docente);
            } else {
                flash("No hay fecha disponible para subir su productividad académica. <strong>" . $fecha->fechainicio . " - " . $fecha->fechafin . "</strong>")->warning();
                return redirect()->route('libro.index');
            }
        } else {
            flash("No hay fecha disponible para subir su productividad académica. <strong>" . $fecha->fechainicio . " - " . $fecha->fechafin . "</strong>")->warning();
            return redirect()->route('libro.index');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LibroRequest $request) {
        $solicitud = new Solicitud($request->all());
        foreach ($solicitud->attributesToArray() as $key => $value) {
            $solicitud->$key = strtoupper($value);
        }
        $solicitud->tipo = "LIBRO";
        $hoy = getdate();
        if (isset($request->cvlac)) {
            $file = $request->file("cvlac");
            $name = "Cvlac_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
            $path = public_path() . "/docs/libros/cvlac/";
            $file->move($path, $name);
            $solicitud->cvlac = $name;
        } else {
            $solicitud->cvlac = "NO";
        }
        if (isset($request->gruplac)) {
            $file = $request->file("gruplac");
            $name = "Gruplac_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
            $path = public_path() . "/docs/libros/gruplac/";
            $file->move($path, $name);
            $solicitud->gruplac = $name;
        } else {
            $solicitud->gruplac = "NO";
        }
        $u = Auth::user();
        $solicitud->user_change = $u->identificacion;
        $solicitud->fecha = $request->fechapublicacion;
        $idr = substr($u->identificacion, -3);
        $solicitud->radicado = $idr . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"];
        $aut = $request->num_autores;
        if ($request->tipo == "LI") {
            if ($aut <= 3) {
                $solicitud->puntos_aproximados_ps = 20;
            }
            if ($aut >= 4 && $aut <= 5) {
                $solicitud->puntos_aproximados_ps = 20 / 2;
            }
            if ($aut >= 6) {
                $solicitud->puntos_aproximados_ps = 20 / ($aut / 2);
            }
        } else {
            if ($aut <= 3) {
                $solicitud->puntos_aproximados_ps = 15;
            }
            if ($aut >= 4 && $aut <= 5) {
                $solicitud->puntos_aproximados_ps = 15 / 2;
            }
            if ($aut >= 6) {
                $solicitud->puntos_aproximados_ps = 15 / ($aut / 2);
            }
        }
        $solicitud->puntos_aproximados_bo = 0;
        $solicitud->puntos_bo = 0;
        $result = $solicitud->save();
        if ($result) {
            $libro = new Libro($request->all());
            foreach ($libro->attributesToArray() as $key => $value) {
                $libro->$key = strtoupper($value);
            }
            if (isset($request->libro_pdf)) {
                $file = $request->file("libro_pdf");
                $name = "Libro_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
                $path = public_path() . "/docs/libros/pdf/";
                $file->move($path, $name);
                $libro->libro_pdf = $name;
            } else {
                $libro->libro_pdf = "NO";
            }
            if (isset($request->cert_vicerrectoria)) {
                $file = $request->file("cert_vicerrectoria");
                $name = "Cert-Vicerrectoria_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
                $path = public_path() . "/docs/libros/certificados/";
                $file->move($path, $name);
                $libro->cert_vicerrectoria = $name;
            } else {
                $libro->cert_vicerrectoria = "NO";
            }
            $libro->solicitud_id = $solicitud->id;
            $libro->user_change = $u->identificacion;
            $result2 = $libro->save();
            if ($result2) {
                $aud = new Auditoriasolicitud();
                $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $aud->operacion = "INSERTAR";
                $str = "CREACIÓN DE SOLICTUD TIPO LIBRO. DATOS: ";
                foreach ($libro->attributesToArray() as $key => $value) {
                    $str = $str . ", " . $key . ": " . $value;
                }
                $aud->detalles = $str;
                $aud->save();
                flash("La Productividad Académica <strong>" . $solicitud->titulo . "</strong> fue almacenada de forma exitosa!")->success();
                return redirect()->route('libro.index');
            } else {
                $solicitud->delete();
                flash("La Productividad Académica <strong>" . $solicitud->titulo . "</strong> no pudo ser almacenada. Error: " . $result)->error();
                return redirect()->route('libro.index');
            }
        } else {
            flash("La Productividad Académica <strong>" . $solicitud->titulo . "</strong> no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('libro.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $libro = Libro::find($id);
        $solicitud = $libro->solicitud;
        $nombre = $solicitud->docente->primer_nombre . " " . $solicitud->docente->segundo_nombre . " " . $solicitud->docente->primer_apellido . " " . $solicitud->docente->segundo_apellido;
        $docente = $solicitud->docente;
        return view('solicitud.libros.libros_docente.show')
                        ->with('location', 'solicitud')
                        ->with('libro', $libro)
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
        $libro = Libro::find($id);
        $solicitud = $libro->solicitud;
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
                return view('solicitud.libros.libros_docente.edit')
                                ->with('location', 'solicitud')
                                ->with('docente', $docente)
                                ->with('libro', $libro);
            } else {
                flash("No hay fecha disponible para modificar su productividad académica. <strong>" . $fecha->fechainicio . " - " . $fecha->fechafin . "</strong>")->warning();
                return redirect()->route('libro.index');
            }
        } else {
            flash("No hay fecha disponible para modificar su productividad académica. <strong>" . $fecha->fechainicio . " - " . $fecha->fechafin . "</strong>")->warning();
            return redirect()->route('libro.index');
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
        $libro = Libro::find($id);
        $solicitud = Solicitud::find($libro->solicitud_id);
        $m = new Solicitud($solicitud->attributesToArray());
        foreach ($solicitud->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $solicitud->$key = strtoupper($request->$key);
            }
        }
        $solicitud->tipo = "LIBRO";
        $hoy = getdate();
        if (isset($request->cvlac)) {
            if (unlink(public_path() . "/docs/libros/cvlac/" . $m->cvlac)) {
                $file = $request->file("cvlac");
                $name = "Cvlac_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
                $path = public_path() . "/docs/libros/cvlac/";
                $file->move($path, $name);
                $solicitud->cvlac = $name;
            }
        }
        if (isset($request->gruplac)) {
            if (unlink(public_path() . "/docs/libros/gruplac/" . $m->gruplac)) {
                $file = $request->file("gruplac");
                $name = "Gruplac_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
                $path = public_path() . "/docs/libros/gruplac/";
                $file->move($path, $name);
                $solicitud->gruplac = $name;
            }
        }
        $u = Auth::user();
        $solicitud->user_change = $u->identificacion;
        $aut = $request->num_autores;
        if ($request->tipo == "LI") {
            if ($aut <= 3) {
                $solicitud->puntos_aproximados_ps = 20;
            }
            if ($aut >= 4 && $aut <= 5) {
                $solicitud->puntos_aproximados_ps = 20 / 2;
            }
            if ($aut >= 6) {
                $solicitud->puntos_aproximados_ps = 20 / ($aut / 2);
            }
        } else {
            if ($aut <= 3) {
                $solicitud->puntos_aproximados_ps = 15;
            }
            if ($aut >= 4 && $aut <= 5) {
                $solicitud->puntos_aproximados_ps = 15 / 2;
            }
            if ($aut >= 6) {
                $solicitud->puntos_aproximados_ps = 15 / ($aut / 2);
            }
        }
        $result = $solicitud->save();
        if ($result) {
            $a = new Libro($libro->attributesToArray());
            foreach ($libro->attributesToArray() as $key => $value) {
                if (isset($request->$key)) {
                    $libro->$key = strtoupper($request->$key);
                }
            }
            if (isset($request->libro_pdf)) {
                if (unlink(public_path() . "/docs/libros/pdf/" . $a->libro_pdf)) {
                    $file = $request->file("libro_pdf");
                    $name = "Libro_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
                    $path = public_path() . "/docs/libros/pdf/";
                    $file->move($path, $name);
                    $libro->libro_pdf = $name;
                }
            }
            if (isset($request->cert_vicerrectoria)) {
                if (unlink(public_path() . "/docs/libros/certificados/" . $a->cert_vicerrectoria)) {
                    $file = $request->file("publindex");
                    $name = "Cert-Vicerrectoria_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
                    $path = public_path() . "/docs/libros/certificados/";
                    $file->move($path, $name);
                    $libro->cert_vicerrectoria = $name;
                }
            }
            $libro->user_change = $u->identificacion;
            $result2 = $libro->save();
            if ($result2) {
                $aud = new Auditoriasolicitud();
                $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $aud->operacion = "ACTUALIZAR DATOS";
                $str = "EDICION DE LIBRO. DATOS NUEVOS: ";
                $str2 = " DATOS ANTIGUOS: ";
                foreach ($a->attributesToArray() as $key => $value) {
                    $str2 = $str2 . ", " . $key . ": " . $value;
                }
                foreach ($libro->attributesToArray() as $key => $value) {
                    $str = $str . ", " . $key . ": " . $value;
                }
                $aud->detalles = $str . " - " . $str2;
                $aud->save();
                flash("El Libro <strong>" . $libro->solicitud->titulo . "</strong> fue modificado de forma exitosa!")->success();
                return redirect()->route('libro.index');
            } else {
                $solicitud = $m;
                $libro = $a;
                flash("El Libro <strong>" . $libro->solicitud->titulo . "</strong> no pudo ser modificado. Error: " . $result)->error();
                return redirect()->route('libro.index');
            }
        } else {
            flash("El Libro <strong>" . $libro->solicitud->titulo . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('libro.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $libro = Libro::find($id);
        $solicitud = $libro->solicitud;
        $e = $solicitud->gruplac;
        $b = $solicitud->cvlac;
        $c = $libro->libro_pdf;
        $d = $libro->cert_vicerrectoria;
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
                    unlink(public_path() . "/docs/libros/cvlac/" . $b);
                    unlink(public_path() . "/docs/libros/gruplac/" . $e);
                    unlink(public_path() . "/docs/libros/certificados/" . $d);
                    unlink(public_path() . "/docs/libros/pdf/" . $c);
                    $aud = new Auditoriasolicitud();
                    $u = Auth::user();
                    $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                    $aud->operacion = "ELIMINAR";
                    $str = "ELIMINACIÓN DE SOLICITUD DE LIBRO. DATOS ELIMINADOS: ";
                    foreach ($solicitud->attributesToArray() as $key => $value) {
                        $str = $str . ", " . $key . ": " . $value;
                    }
                    $aud->detalles = $str;
                    $aud->save();
                    flash("La Productividad Académica <strong>" . $solicitud->titulo . "</strong> fue eliminada de forma exitosa!")->success();
                    return redirect()->route('libro.index');
                } else {
                    flash("La Productividad Académica <strong>" . $solicitud->titulo . "</strong> no pudo ser eliminada. Error: " . $result)->error();
                    return redirect()->route('libro.index');
                }
            } else {
                flash("No hay fecha disponible para eliminar su productividad académica.<strong>" . $fecha->fechainicio . " - " . $fecha->fechafin . "</strong>")->warning();
                return redirect()->route('libro.index');
            }
        } else {
            flash("No hay fecha disponible para eliminar su productividad académica. <strong>" . $fecha->fechainicio . " - " . $fecha->fechafin . "</strong>")->warning();
            return redirect()->route('libro.index');
        }
    }

    /**
     * Evalua una solicitud de tipo artículo.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function evaluar($id) {
        $libro = Libro::find($id);
        $solicitud = $libro->solicitud;
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
                    return view('solicitud.libros.libros_admin.evaluar')
                                    ->with('location', 'solicitud')
                                    ->with('solicitud', $solicitud)
                                    ->with('libro', $libro)
                                    ->with('docente', $docente);
                } else {
                    flash("La Productividad seleccionada ya fue evaluada.")->warning();
                    return redirect()->route('libro.indexadmin');
                }
            } else {
                flash("No hay fecha disponible para evaluar productividad académica. <strong>" . $fecha->fechainicio . " - " . $fecha->fechafin . "</strong>")->warning();
                return redirect()->route('libro.indexadmin');
            }
        } else {
            flash("No hay fecha disponible para evaluar productividad académica. <strong>" . $fecha->fechainicio . " - " . $fecha->fechafin . "</strong>")->warning();
            return redirect()->route('libro.indexadmin');
        }
    }

    public function calificar(Request $request) {
        $hoy = getdate();
        $libro = Libro::find($request->libro_id);
        $solicitud = Solicitud::find($request->solicitud_id);
        $solicitud->estado = $request->estado;
        $solicitud->observacion = strtoupper($request->observacion);
        $solicitud->puntos_ps = $request->puntos_ps;
        $solicitud->puntos_bo = 0;
        $solicitud->fecha = $hoy["year"] . "-" . $hoy["mon"] . "-" . $hoy["mday"];
        $result = $solicitud->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriasolicitud();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "EVALUAR";
            $str = "ASIGNACIÓN DE PUNTOS A SOLICTUD TIPO LIBRO. DATOS: ";
            foreach ($libro->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La Productividad Académica <strong>" . $solicitud->titulo . "</strong> fue evaluada de forma exitosa!")->success();
            return redirect()->route('libro.indexadmin');
        } else {
            flash("La Productividad Académica <strong>" . $solicitud->titulo . "</strong> no pudo ser evaluada. Error: " . $result)->error();
            return redirect()->route('libro.index');
        }
    }

}
