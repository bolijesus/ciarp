<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FechacierreRequest;
use App\Fechacierre;
use App\Auditoriasolicitud;
use Illuminate\Support\Facades\Auth;

class FechacierreController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $fechas = Fechacierre::all();
        $fechas = $fechas->sortByDesc('estado');
        return view('solicitud.carga_administrativa.fecha_cierre.list')
                        ->with('location', 'solicitud')
                        ->with('fechas', $fechas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('solicitud.carga_administrativa.fecha_cierre.create')
                        ->with('location', 'solicitud');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FechacierreRequest $request) {
        if ($request->estado == 'ACTIVA') {
            $existe = Fechacierre::where('estado', 'ACTIVA')->first();
            if ($existe !== null) {
                flash("La Fecha no pudo ser almacenada porque ya hay una fecha ACTIVA. Cambie el estado.")->warning();
                return redirect()->route('fecha.index');
            }
        }
        $fecha = new Fechacierre($request->all());
        foreach ($fecha->attributesToArray() as $key => $value) {
            $fecha->$key = strtoupper($value);
        }
        $u = Auth::user();
        $fecha->user_change = $u->identificacion;
        $result = $fecha->save();
        if ($result) {
            $aud = new Auditoriasolicitud();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE FECHA DE CIERRE. DATOS: ";
            foreach ($fecha->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La Fecha <strong>" . $fecha->fechainicio . " - " . $fecha->fechafin . "</strong> fue almacenada de forma exitosa!")->success();
            return redirect()->route('fecha.index');
        } else {
            flash("La Fecha <strong>" . $fecha->fechainicio . " - " . $fecha->fechafin . "</strong> no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('fecha.index');
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
        $fecha = Fechacierre::find($id);
        return view('solicitud.carga_administrativa.fecha_cierre.edit')
                        ->with('location', 'solicitud')
                        ->with('fecha', $fecha);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $fecha = Fechacierre::find($id);
        if ($request->estado == 'ACTIVA') {
            $existe = Fechacierre::where('estado', 'ACTIVA')->first();
            if ($existe !== null) {
                if ($existe->id !== $fecha->id) {
                    flash("La Fecha <strong>" . $fecha->fechainicio . " " . $fecha->fechafin . "</strong> no pudo ser modificada, ya existe una fecha ACTIVA, por favor cambie el estado. Error!")->warning();
                    return redirect()->route('fecha.index');
                }
            }
        }
        $m = new Fechacierre($fecha->attributesToArray());
        foreach ($fecha->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $fecha->$key = strtoupper($request->$key);
            }
        }
        if ($request->fechainicio1 != null) {
            $fecha->fechainicio = $request->fechainicio1;
        }
        if ($request->fechafin1 != null) {
            $fecha->fechafin = $request->fechafin1;
        }
        $u = Auth::user();
        $fecha->user_change = $u->identificacion;
        $result = $fecha->save();
        if ($result) {
            $aud = new Auditoriasolicitud();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE FECHA DE CIERRE. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($fecha->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("La Fecha <strong>" . $fecha->fechainicio . " " . $fecha->fechafin . "</strong> fue modificada de forma exitosa!")->success();
            return redirect()->route('fecha.index');
        } else {
            flash("La Fecha <strong>" . $fecha->fechainicio . " " . $fecha->fechafin . "</strong> no pudo ser modificada. Error: " . $result)->error();
            return redirect()->route('fecha.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $fecha = Fechacierre::find($id);
//        if (count($fecha->solicituds) > 0) {
//            flash("El Docente <strong>" . $fecha->primer_nombre . " " . $fecha->primer_apellido . "</strong> no pudo ser eliminado porque tiene productividad asociadas.")->warning();
//            return redirect()->route('docente.index');
//        } else {
        $result = $fecha->delete();
        if ($result) {
            $aud = new Auditoriasolicitud();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE FECHA. DATOS ELIMINADOS: ";
            foreach ($fecha->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La Fecha <strong>" . $fecha->fechainicio . " " . $fecha->fechafin . "</strong> fue eliminado de forma exitosa!")->success();
            return redirect()->route('fecha.index');
        } else {
            flash("La Fecha <strong>" . $fecha->fechainicio . " " . $fecha->fechafin . "</strong> no pudo ser eliminado. Error: " . $result)->error();
            return redirect()->route('fecha.index');
        }
        //       }
    }

}
