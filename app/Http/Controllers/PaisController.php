<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pais;
use App\Http\Requests\PaisRequest;

class PaisController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $paises = pais::all();
        return view('feligresia.datos_geograficos.paises.list')
                        ->with('location', 'feligresia')
                        ->with('paises', $paises);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('feligresia.datos_geograficos.paises.create')
                        ->with('location', 'feligresia');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaisRequest $request) {
        $pais = new Pais($request->all());
        foreach ($pais->attributesToArray() as $key => $value) {
            $pais->$key = strtoupper($value);
        }
        $result = $pais->save();
        if ($result) {
            flash("El Pais <strong>" . $pais->nombre . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('pais.index');
        } else {
            flash("El Pais <strong>" . $pais->nombre . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('pais.index');
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
        $pais = Pais::find($id);
        return view('feligresia.datos_geograficos.paises.edit')
                        ->with('location', 'feligresia')
                        ->with('pais', $pais);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $pais = Pais::find($id);
        foreach ($pais->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $pais->$key = strtoupper($request->$key);
            }
        }
        $result = $pais->save();
        if ($result) {
            flash("El Pais <strong>" . $pais->nombre . "</strong> fue modificado de forma exitosa!")->success();
            return redirect()->route('pais.index');
        } else {
            flash("El Pais <strong>" . $pais->nombre . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('pais.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $pais = Pais::find($id);
        if (count($pais->departamentos) > 0) {
            flash("El Pais <strong>" . $pais->nombre . "</strong> no pudo ser eliminado porque tiene estados/departamentos asociados.")->warning();
            return redirect()->route('pais.index');
        } else {
            $result = $pais->delete();
            if ($result) {
                flash("El Pais <strong>" . $pais->nombre . "</strong> fue eliminado de forma exitosa!")->success();
                return redirect()->route('pais.index');
            } else {
                flash("El Pais <strong>" . $pais->nombre . "</strong> no pudo ser eliminado. Error: " . $result)->error();
                return redirect()->route('pais.index');
            }
        }
    }

    /**
     * show all resource from a pais.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function estados($id) {
        $pais = Pais::find($id);
        $estados = $pais->departamentos;
        if (count($estados) > 0) {
            $estadosf = null;
            foreach ($estados as $value) {
                $obj["id"] = $value->id;
                $obj["value"] = $value->nombre;
                $estadosf[] = $obj;
            }
            return json_encode($estadosf);
        } else {
            return "null";
        }
    }

}
