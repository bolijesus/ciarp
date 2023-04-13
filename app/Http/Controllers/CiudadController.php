<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ciudad;
use App\Http\Requests\CiudadRequest;
use App\Departamento;

class CiudadController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $ciudades = Ciudad::all();
        $ciudades->each(function ($ciudad) {
            $ciudad->departamento;
        });
        return view('feligresia.datos_geograficos.ciudades.list')
                        ->with('location', 'feligresia')
                        ->with('ciudades', $ciudades);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $estados = Departamento::all()->pluck('nombre', 'id');
        return view('feligresia.datos_geograficos.ciudades.create')
                        ->with('location', 'feligresia')
                        ->with('estados', $estados);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CiudadRequest $request) {
        $ciudad = new Ciudad($request->all());
        foreach ($ciudad->attributesToArray() as $key => $value) {
            $ciudad->$key = strtoupper($value);
        }
        $result = $ciudad->save();
        if ($result) {
            flash("La Ciudad <strong>" . $ciudad->nombre . "</strong> fue almacenada de forma exitosa!")->success();
            return redirect()->route('ciudad.index');
        } else {
            flash("La Ciudad <strong>" . $ciudad->nombre . "</strong> no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('ciudad.index');
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
        $ciudad = Ciudad::find($id);
        $estados = Departamento::all()->pluck('nombre', 'id');
        return view('feligresia.datos_geograficos.ciudades.edit')
                        ->with('location', 'feligresia')
                        ->with('ciudad', $ciudad)
                        ->with('estados', $estados);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $ciudad = Ciudad::find($id);
        foreach ($ciudad->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $ciudad->$key = strtoupper($request->$key);
            }
        }
        $result = $ciudad->save();
        if ($result) {
            flash("La Ciudad <strong>" . $ciudad->nombre . "</strong> fue modificada de forma exitosa!")->success();
            return redirect()->route('ciudad.index');
        } else {
            flash("La Ciudad <strong>" . $ciudad->nombre . "</strong> no pudo ser modificada. Error: " . $result)->error();
            return redirect()->route('ciudad.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $ciudad = Ciudad::find($id);
        $result = $ciudad->delete();
        if ($result) {
            flash("La Ciudad <strong>" . $ciudad->nombre . "</strong> fue eliminada de forma exitosa!")->success();
            return redirect()->route('ciudad.index');
        } else {
            flash("La Ciudad <strong>" . $ciudad->nombre . "</strong> no pudo ser eliminada. Error: " . $result)->error();
            return redirect()->route('ciudad.index');
        }
    }

}
