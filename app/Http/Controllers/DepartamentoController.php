<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Departamento;
use App\Http\Requests\DepartamentoRequest;
use App\Pais;

class DepartamentoController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $dptos = Departamento::all();
        $dptos->each(function ($dptos) {
            $dptos->pais;
        });
        return view('feligresia.datos_geograficos.departamentos.list')
                        ->with('location', 'feligresia')
                        ->with('dptos', $dptos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $paises = Pais::all()->pluck('nombre', 'id');
        return view('feligresia.datos_geograficos.departamentos.create')
                        ->with('location', 'feligresia')
                        ->with('paises', $paises);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartamentoRequest $request) {
        $estado = new Departamento($request->all());
        foreach ($estado->attributesToArray() as $key => $value) {
            $estado->$key = strtoupper($value);
        }
        $result = $estado->save();
        if ($result) {
            flash("El Departamento <strong>" . $estado->nombre . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('estado.index');
        } else {
            flash("El Departamento <strong>" . $estado->nombre . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('estado.index');
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
        $estado = Departamento::find($id);
        $paises = Pais::all()->pluck('nombre', 'id');
        return view('feligresia.datos_geograficos.departamentos.edit')
                        ->with('location', 'feligresia')
                        ->with('estado', $estado)
                        ->with('paises', $paises);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $estado = Departamento::find($id);
        foreach ($estado->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $estado->$key = strtoupper($request->$key);
            }
        }
        $result = $estado->save();
        if ($result) {
            flash("El Departamento <strong>" . $estado->nombre . "</strong> fue modificado de forma exitosa!")->success();
            return redirect()->route('estado.index');
        } else {
            flash("El Departamento <strong>" . $estado->nombre . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('estado.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $estado = Departamento::find($id);
        if (count($estado->ciudades) > 0) {
            flash("El Departamento <strong>" . $estado->nombre . "</strong> no pudo ser eliminado porque tiene ciudades/municipios asociados.")->warning();
            return redirect()->route('estado.index');
        } else {
            $result = $estado->delete();
            if ($result) {
                flash("El Departamento <strong>" . $estado->nombre . "</strong> fue eliminado de forma exitosa!")->success();
                return redirect()->route('estado.index');
            } else {
                flash("El Departamento <strong>" . $estado->nombre . "</strong> no pudo ser eliminado. Error: " . $result)->error();
                return redirect()->route('estado.index');
            }
        }
    }

    /**
     * show all resource from a estado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ciudades($id) {
        $estado = Departamento::find($id);
        $ciudades = $estado->ciudades;
        if (count($ciudades) > 0) {
            $ciudadesf = null;
            foreach ($ciudades as $value) {
                $obj["id"] = $value->id;
                $obj["value"] = $value->nombre;
                $ciudadesf[] = $obj;
            }
            return json_encode($ciudadesf);
        } else {
            return "null";
        }
    }

}
