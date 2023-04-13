<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Software;
use App\Docente;
use App\Solicitud;
use App\Fechacierre;
use App\Auditoriasolicitud;
use App\Autor;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SoftwareRequest;

class SoftwareController extends Controller {

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
        $solicitudes = Solicitud::where([['tipo', 'SOFTWARE'], ['docente_id', $docente->id]])->get();
        //convertir articulo en coleccion
        $softwares = null;
        if (count($solicitudes) > 0) {
            foreach ($solicitudes as $s) {
                $softwares[] = Software::where('solicitud_id', $s->id)->first();
            }
        }
        return view('solicitud.software.software_docente.list')
                        ->with('location', 'solicitud')
                        ->with('softwares', $softwares);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexadmin() {
        $software = Software::all();
        return view('solicitud.software.software_admin.list')
                        ->with('location', 'solicitud')
                        ->with('software', $software);
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
                return view('solicitud.software.software_docente.create')
                                ->with('location', 'solicitud')
                                ->with('docente', $docente);
            } else {
                flash("No hay fecha disponible para subir su productividad académica. <strong>" . $fecha->fechainicio . " - " . $fecha->fechafin . "</strong>")->warning();
                return redirect()->route('software.index');
            }
        } else {
            flash("No hay fecha disponible para subir su productividad académica. <strong>" . $fecha->fechainicio . " - " . $fecha->fechafin . "</strong>")->warning();
            return redirect()->route('software.index');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SoftwareRequest $request) {
        $autores = explode(",", $request->autores);
        if (count($autores) != $request->num_autores) {
            flash("El numero de autores debe ser igual a la cantidad de autores descritos.")->warning();
            return redirect()->route('software.index');
        }
        $solicitud = new Solicitud($request->all());
        foreach ($solicitud->attributesToArray() as $key => $value) {
            $solicitud->$key = strtoupper($value);
        }
        $solicitud->tipo = "SOFTWARE";
        $hoy = getdate();
        if (isset($request->cvlac)) {
            $file = $request->file("cvlac");
            $name = "Cvlac_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
            $path = public_path() . "/docs/software/cvlac/";
            $file->move($path, $name);
            $solicitud->cvlac = $name;
        } else {
            $solicitud->cvlac = "NO";
        }
        if (isset($request->gruplac)) {
            $file = $request->file("gruplac");
            $name = "Gruplac_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
            $path = public_path() . "/docs/software/gruplac/";
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
        if ($request->num_autores <= 3) {
            $solicitud->puntos_aproximados_ps = 15;
        }
        if ($request->num_autores >= 4 && $request->num_autores <= 5) {
            $solicitud->puntos_aproximados_ps = 15 / 2;
        }
        if ($request->num_autores >= 6) {
            $solicitud->puntos_aproximados_ps = 15 / (num_autores / 2);
        }
        $solicitud->puntos_aproximados_bo = 0;
        $solicitud->puntos_bo = 0;
        $result = $solicitud->save();
        if ($result) {
            $software = new Software($request->all());
            foreach ($software->attributesToArray() as $key => $value) {
                $software->$key = strtoupper($value);
            }
            if (isset($request->codigo)) {
                $file = $request->file("codigo");
                $name = "Codigo_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
                $path = public_path() . "/docs/software/codigo/";
                $file->move($path, $name);
                $software->codigo = $name;
            } else {
                $software->codigo = "NO";
            }
            if (isset($request->ejecutable)) {
                $file = $request->file("ejecutable");
                $name = "Ejecutable_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
                $path = public_path() . "/docs/software/ejecutable/";
                $file->move($path, $name);
                $software->ejecutable = $name;
            } else {
                $software->ejecutable = "NO";
            }
            if (isset($request->instrucciones)) {
                $file = $request->file("instrucciones");
                $name = "Instrucciones_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
                $path = public_path() . "/docs/software/instrucciones/";
                $file->move($path, $name);
                $software->instrucciones = $name;
            } else {
                $software->instrucciones = "NO";
            }
            if (isset($request->cer_imp_upc)) {
                $file = $request->file("cer_imp_upc");
                $name = "Cert-Impacto_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
                $path = public_path() . "/docs/software/impacto/";
                $file->move($path, $name);
                $software->cert_imp_upc = $name;
            } else {
                $software->cert_imp_upc = "NO";
            }
            if (isset($request->manual)) {
                $file = $request->file("manual");
                $name = "Manuales_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
                $path = public_path() . "/docs/software/manual/";
                $file->move($path, $name);
                $software->manual = $name;
            } else {
                $software->manual = "NO";
            }
            if (isset($request->cer_registro)) {
                $file = $request->file("cer_registro");
                $name = "Cert-Registro_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
                $path = public_path() . "/docs/software/cer_registro/";
                $file->move($path, $name);
                $software->cert_registro = $name;
            } else {
                $software->cert_registro = "NO";
            }
            $software->solicitud_id = $solicitud->id;
            $software->user_change = $u->identificacion;
            $result2 = $software->save();
            if ($result2) {
                $aud = new Auditoriasolicitud();
                $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $aud->operacion = "INSERTAR";
                $str = "CREACIÓN DE SOLICTUD TIPO SOFTWARE. DATOS: ";
                foreach ($software->attributesToArray() as $key => $value) {
                    $str = $str . ", " . $key . ": " . $value;
                }
                $aud->detalles = $str;
                $aud->save();
                flash("La Productividad Académica <strong>" . $solicitud->titulo . "</strong> fue almacenada de forma exitosa!")->success();
                return redirect()->route('software.index');
            } else {
                $solicitud->delete();
                flash("La Productividad Académica <strong>" . $solicitud->titulo . "</strong> no pudo ser almacenada. Error: " . $result)->error();
                return redirect()->route('software.index');
            }
        } else {
            flash("La Productividad Académica <strong>" . $solicitud->titulo . "</strong> no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('software.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $software = Software::find($id);
        $solicitud = $software->solicitud;
        $nombre = $solicitud->docente->primer_nombre . " " . $solicitud->docente->segundo_nombre . " " . $solicitud->docente->primer_apellido . " " . $solicitud->docente->segundo_apellido;
        $docente = $solicitud->docente;
        return view('solicitud.software.software_docente.show')
                        ->with('location', 'solicitud')
                        ->with('software', $software)
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
        $software = Software::find($id);
        $solicitud = $software->solicitud;
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
                return view('solicitud.software.software_docente.edit')
                                ->with('location', 'solicitud')
                                ->with('docente', $docente)
                                ->with('software', $software);
            } else {
                flash("No hay fecha disponible para modificar su productividad académica. <strong>" . $fecha->fechainicio . " - " . $fecha->fechafin . "</strong>")->warning();
                return redirect()->route('software.index');
            }
        } else {
            flash("No hay fecha disponible para modificar su productividad académica. <strong>" . $fecha->fechainicio . " - " . $fecha->fechafin . "</strong>")->warning();
            return redirect()->route('software.index');
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
        $autores = explode(",", $request->autores);
        if (count($autores) != $request->num_autores) {
            flash("El numero de autores debe ser igual a la cantidad de autores descritos.")->warning();
            return redirect()->route('software.index');
        }
        $software = Software::find($id);
        $solicitud = Solicitud::find($software->solicitud_id);
        $m = new Solicitud($solicitud->attributesToArray());
        foreach ($solicitud->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $solicitud->$key = strtoupper($request->$key);
            }
        }
        $solicitud->tipo = "SOFTWARE";
        $hoy = getdate();
        if (isset($request->cvlac)) {
            if (unlink(public_path() . "/docs/software/cvlac/" . $m->cvlac)) {
                $file = $request->file("cvlac");
                $name = "Cvlac_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
                $path = public_path() . "/docs/software/cvlac/";
                $file->move($path, $name);
                $solicitud->cvlac = $name;
            }
        }
        if (isset($request->gruplac)) {
            if (unlink(public_path() . "/docs/software/gruplac/" . $m->gruplac)) {
                $file = $request->file("gruplac");
                $name = "Gruplac_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
                $path = public_path() . "/docs/software/gruplac/";
                $file->move($path, $name);
                $solicitud->gruplac = $name;
            }
        }
        $u = Auth::user();
        $solicitud->user_change = $u->identificacion;
        if ($request->num_autores <= 3) {
            $solicitud->puntos_aproximados_ps = 15;
        }
        if ($request->num_autores >= 4 && $request->num_autores <= 5) {
            $solicitud->puntos_aproximados_ps = 15 / $request->num_autores;
        }
        if ($request->num_autores >= 6) {
            $solicitud->puntos_aproximados_ps = 15 / (num_autores / 2);
        }
        $result = $solicitud->save();
        if ($result) {
            $a = new Software($software->attributesToArray());
            foreach ($software->attributesToArray() as $key => $value) {
                if (isset($request->$key)) {
                    $software->$key = strtoupper($request->$key);
                }
            }
            if (isset($request->codigo)) {
                if (unlink(public_path() . "/docs/software/codigo/" . $a->codigo)) {
                    $file = $request->file("codigo");
                    $name = "Codigo_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
                    $path = public_path() . "/docs/software/codigo/";
                    $file->move($path, $name);
                    $software->codigo = $name;
                }
            }
            if (isset($request->ejecutable)) {
                if (unlink(public_path() . "/docs/software/ejecutable/" . $a->ejecutable)) {
                    $file = $request->file("ejecutable");
                    $name = "Ejecutable_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
                    $path = public_path() . "/docs/software/ejecutable/";
                    $file->move($path, $name);
                    $software->ejecutable = $name;
                }
            }
            if (isset($request->instrucciones)) {
                if (unlink(public_path() . "/docs/software/instrucciones/" . $a->instrucciones)) {
                    $file = $request->file("instrucciones");
                    $name = "Instrucciones_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
                    $path = public_path() . "/docs/software/instrucciones/";
                    $file->move($path, $name);
                    $software->instrucciones = $name;
                }
            }
            if (isset($request->cer_imp_upc)) {
                if (unlink(public_path() . "/docs/software/instrucciones/" . $a->cer_imp_upc)) {
                    $file = $request->file("cer_imp_upc");
                    $name = "Cer-Impacto_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
                    $path = public_path() . "/docs/software/impacto/";
                    $file->move($path, $name);
                    $software->cer_imp_upc = $name;
                }
            }
            if (isset($request->manual)) {
                if (unlink(public_path() . "/docs/software/manual/" . $a->manual)) {
                    $file = $request->file("manual");
                    $name = "Manuales_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
                    $path = public_path() . "/docs/software/manual/";
                    $file->move($path, $name);
                    $software->manual = $name;
                }
            }
            if (isset($request->cer_registro)) {
                if (unlink(public_path() . "/docs/software/cer_registro/" . $a->cert_registro)) {
                    $file = $request->file("cer_registro");
                    $name = "Cer-Registro_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
                    $path = public_path() . "/docs/software/cer_registro/";
                    $file->move($path, $name);
                    $software->cert_registro = $name;
                }
            }
            $software->user_change = $u->identificacion;
            $result2 = $software->save();
            if ($result2) {
                $aud = new Auditoriasolicitud();
                $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $aud->operacion = "ACTUALIZAR DATOS";
                $str = "EDICION DE SOFTWARE. DATOS NUEVOS: ";
                $str2 = " DATOS ANTIGUOS: ";
                foreach ($a->attributesToArray() as $key => $value) {
                    $str2 = $str2 . ", " . $key . ": " . $value;
                }
                foreach ($software->attributesToArray() as $key => $value) {
                    $str = $str . ", " . $key . ": " . $value;
                }
                $aud->detalles = $str . " - " . $str2;
                $aud->save();
                flash("El Software <strong>" . $software->solicitud->titulo . "</strong> fue modificado de forma exitosa!")->success();
                return redirect()->route('software.index');
            } else {
                $solicitud = $m;
                $software = $a;
                flash("El Software <strong>" . $software->solicitud->titulo . "</strong> no pudo ser modificado. Error: " . $result)->error();
                return redirect()->route('software.index');
            }
        } else {
            flash("El Software <strong>" . $software->solicitud->titulo . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('software.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $software = Software::find($id);
        $solicitud = $software->solicitud;
        $e = $solicitud->gruplac;
        $b = $solicitud->cvlac;
        $c = $software->codigo;
        $d = $software->instrucciones;
        $f = $software->cert_registro;
        $g = $software->ejecutable;
        $j = $software->cert_imp_upc;
        $i = $software->manual;
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
                    unlink(public_path() . "/docs/software/cvlac/" . $b);
                    unlink(public_path() . "/docs/software/gruplac/" . $e);
                    unlink(public_path() . "/docs/software/codigo/" . $c);
                    unlink(public_path() . "/docs/software/instrucciones/" . $d);
                    unlink(public_path() . "/docs/software/cer_registro/" . $f);
                    unlink(public_path() . "/docs/software/ejecutable/" . $g);
                    unlink(public_path() . "/docs/software/impacto/" . $j);
                    unlink(public_path() . "/docs/software/manual/" . $i);
                    $aud = new Auditoriasolicitud();
                    $u = Auth::user();
                    $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                    $aud->operacion = "ELIMINAR";
                    $str = "ELIMINACIÓN DE SOLICITUD DE SOFTWARE. DATOS ELIMINADOS: ";
                    foreach ($solicitud->attributesToArray() as $key => $value) {
                        $str = $str . ", " . $key . ": " . $value;
                    }
                    $aud->detalles = $str;
                    $aud->save();
                    flash("La Productividad Académica <strong>" . $solicitud->titulo . "</strong> fue eliminada de forma exitosa!")->success();
                    return redirect()->route('softtware.index');
                } else {
                    flash("La Productividad Académica <strong>" . $solicitud->titulo . "</strong> no pudo ser eliminada. Error: " . $result)->error();
                    return redirect()->route('softtware.index');
                }
            } else {
                flash("No hay fecha disponible para eliminar su productividad académica.<strong>" . $fecha->fechainicio . " - " . $fecha->fechafin . "</strong>")->warning();
                return redirect()->route('softtware.index');
            }
        } else {
            flash("No hay fecha disponible para eliminar su productividad académica. <strong>" . $fecha->fechainicio . " - " . $fecha->fechafin . "</strong>")->warning();
            return redirect()->route('softtware.index');
        }
    }

    /**
     * Evalua una solicitud de tipo artículo.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function evaluar($id) {
        $software = Software::find($id);
        $solicitud = $software->solicitud;
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
                    return view('solicitud.software.software_admin.evaluar')
                                    ->with('location', 'solicitud')
                                    ->with('solicitud', $solicitud)
                                    ->with('software', $software)
                                    ->with('docente', $docente);
                } else {
                    flash("La Productividad seleccionada ya fue evaluada.")->warning();
                    return redirect()->route('software.indexadmin');
                }
            } else {
                flash("No hay fecha disponible para evaluar productividad académica. <strong>" . $fecha->fechainicio . " - " . $fecha->fechafin . "</strong>")->warning();
                return redirect()->route('software.indexadmin');
            }
        } else {
            flash("No hay fecha disponible para evaluar productividad académica. <strong>" . $fecha->fechainicio . " - " . $fecha->fechafin . "</strong>")->warning();
            return redirect()->route('software.indexadmin');
        }
    }

    public function calificar(Request $request) {
        $hoy = getdate();
        $software = Software::find($request->software_id);
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
            $str = "ASIGNACIÓN DE PUNTOS A SOLICTUD TIPO SOFTWARE. DATOS: ";
            foreach ($software->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La Productividad Académica <strong>" . $solicitud->titulo . "</strong> fue evaluada de forma exitosa!")->success();
            return redirect()->route('software.indexadmin');
        } else {
            flash("La Productividad Académica <strong>" . $solicitud->titulo . "</strong> no pudo ser evaluada. Error: " . $result)->error();
            return redirect()->route('software.index');
        }
    }

}
