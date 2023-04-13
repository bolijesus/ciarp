<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DocenteRequest;
use App\Docente;
use App\Departamentof;
use App\Categoria;
use App\Auditoriausuario;
use Illuminate\Support\Facades\Auth;

class DocenteController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $docentes = Docente::all();
        return view('solicitud.carga_administrativa.docente.list')
                        ->with('location', 'solicitud')
                        ->with('docentes', $docentes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $depto = Departamentof::all()->pluck('nombre', 'id');
        $categorias = Categoria::all()->pluck('nombre', 'id');
        return view('solicitud.carga_administrativa.docente.create')
                        ->with('location', 'solicitud')
                        ->with('depto', $depto)
                        ->with('categorias', $categorias);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocenteRequest $request) {
        $docente = new Docente($request->all());
        foreach ($docente->attributesToArray() as $key => $value) {
            if ($key == 'correo') {
                $docente->$key = $value;
            } else {
                $docente->$key = strtoupper($value);
            }
        }
        $u = Auth::user();
        $docente->user_change = $u->identificacion;
        $result = $docente->save();
        if ($result) {
            $aud = new Auditoriausuario();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE DOCENTE. DATOS: ";
            foreach ($docente->attributesToArray() as $key => $value) {
                if ($key == 'departamentof_id') {
                    $str = $str . ", " . $key . ": " . $value . ", departamento:" . $docente->departamentof->nombre;
                } else if ($key == 'categoria_id') {
                    $str = $str . ", " . $key . ": " . $value . ", categoria:" . $docente->categoria->nombre;
                } else {
                    $str = $str . ", " . $key . ": " . $value;
                }
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El Docente <strong>" . $docente->primer_nombre . " " . $docente->primer_´apellido . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('docente.index');
        } else {
            flash("El Docente <strong>" . $docente->primer_nombre . " " . $docente->primer_´apellido . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('docente.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $docente = Docente::find($id);
        $depto = Departamentof::all()->pluck('nombre', 'id');
        $categorias = Categoria::all()->pluck('nombre', 'id');
        return view('solicitud.carga_administrativa.docente.edit')
                        ->with('location', 'solicitud')
                        ->with('docente', $docente)
                        ->with('depto', $depto)
                        ->with('categorias', $categorias);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $docente = Docente::find($id);
        $m = new Docente($docente->attributesToArray());
        foreach ($docente->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                if ($key == 'correo') {
                    $docente->$key = $request->$key;
                } else {
                    $docente->$key = strtoupper($request->$key);
                }
            }
        }
        $u = Auth::user();
        $docente->user_change = $u->identificacion;
        $result = $docente->save();
        if ($result) {
            $aud = new Auditoriausuario();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE DOCENTE. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                if ($key == 'departamentof_id') {
                    $str2 = $str2 . ", " . $key . ": " . $value . ", fepartamento:" . $m->departamentof->nombre;
                } elseif ($key == 'categoria_id') {
                    $str2 = $str2 . ", " . $key . ": " . $value . ", categoria:" . $m->categoria->nombre;
                } else {
                    $str2 = $str2 . ", " . $key . ": " . $value;
                }
            }
            foreach ($docente->attributesToArray() as $key => $value) {
                if ($key == 'departamentof_id') {
                    $str = $str . ", " . $key . ": " . $value . ", departamento:" . $docente->departamentof->nombre;
                } else if ($key == 'categoria_id') {
                    $str = $str . ", " . $key . ": " . $value . ", categoria:" . $docente->categoria->nombre;
                } else {
                    $str = $str . ", " . $key . ": " . $value;
                }
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("El Docente <strong>" . $docente->primer_nombre . " " . $docente->primer_apellido . "</strong> fue modificado de forma exitosa!")->success();
            return redirect()->route('docente.index');
        } else {
            flash("El Docente <strong>" . $docente->primer_nombre . " " . $docente->primer_apellido . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('docente.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $docente = Docente::find($id);
        if (count($docente->solicituds) > 0) {
            flash("El Docente <strong>" . $docente->primer_nombre." ".$docente->primer_apellido . "</strong> no pudo ser eliminado porque tiene productividad asociadas.")->warning();
            return redirect()->route('docente.index');
        } else {
            $result = $docente->delete();
            if ($result) {
                $aud = new Auditoriausuario();
                $u = Auth::user();
                $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $aud->operacion = "ELIMINAR";
                $str = "ELIMINACIÓN DE DOCENTE. DATOS ELIMINADOS: ";
                foreach ($docente->attributesToArray() as $key => $value) {
                    if ($key == 'departamentof_id') {
                        $str = $str . ", " . $key . ": " . $value . ", departamento:" . $docente->departamentof->nombre;
                    } else if ($key == 'categoria_id') {
                        $str = $str . ", " . $key . ": " . $value . ", categoria:" . $docente->categoria->nombre;
                    } else {
                        $str = $str . ", " . $key . ": " . $value;
                    }
                }
                $aud->detalles = $str;
                $aud->save();
                flash("El Docente <strong>" . $docente->primer_nombre." ".$docente->primer_apellido . "</strong> fue eliminado de forma exitosa!")->success();
                return redirect()->route('docente.index');
            } else {
                flash("El Docente <strong>" . $docente->primer_nombre." ".$docente->primer_apellido . "</strong> no pudo ser eliminado. Error: " . $result)->error();
                return redirect()->route('docente.index');
            }
        }
    }

}
