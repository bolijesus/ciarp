<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pqr;
use App\Respuesta;
use App\Solicitud;
use App\Fechapqr;
use Illuminate\Support\Facades\Auth;

class PqrController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $u = Auth::user();
        if (session('ROL') == "ADMINISTRADOR") {
            $pqr = Pqr::all();
        } else {
            $pqr = Pqr::where('user_id', $u->id)->get();
        }
        return view('pqr.list')
                        ->with('location', 'pqr')
                        ->with('pqr', $pqr);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $fecha = Fechapqr::where('estado', 'ACTIVA')->first();
        if ($fecha != null) {
            $hoy = getdate();
            $a = $hoy["year"] . "-" . $hoy["mon"] . "-" . $hoy["mday"] . " " . $hoy["hours"] . ":" . $hoy["minutes"] . ":" . $hoy["seconds"];
            $h = strtotime($a);
            $fi = strtotime($fecha->fechainicio);
            $ff = strtotime($fecha->fechafin);
            if ($h >= $fi && $h <= $ff) {
                return view('pqr.create')
                                ->with('location', 'pqr');
            } else {
                flash("No hay fecha disponible para realizar PQR. <strong>" . $fecha->fechainicio . " - " . $fecha->fechafin . "</strong>")->warning();
                return redirect()->route('pqr.index');
            }
        } else {
            flash("No hay fecha disponible para realizar PQR. <strong>" . $fecha->fechainicio . " - " . $fecha->fechafin . "</strong>")->warning();
            return redirect()->route('pqr.index');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $fecha = Fechapqr::where('estado', 'ACTIVA')->first();
        if ($fecha != null) {
            $hoy = getdate();
            $a = $hoy["year"] . "-" . $hoy["mon"] . "-" . $hoy["mday"] . " " . $hoy["hours"] . ":" . $hoy["minutes"] . ":" . $hoy["seconds"];
            $h = strtotime($a);
            $fi = strtotime($fecha->fechainicio);
            $ff = strtotime($fecha->fechafin);
            if ($h >= $fi && $h <= $ff) {
                $res = new Respuesta($request->all());
                $res->mensaje = strtoupper($res->mensaje);
                $result = $res->save();
                if ($result) {
                    flash("La Respuesta a <strong>" . $res->user->nombres . " " . $res->user->apellidos . "</strong> fue enviado de forma exitosa!")->success();
                    return redirect()->route('pqr.edit', $request->pqr_id);
                } else {
                    flash("La Respuesta a<strong>" . $res->user->nombres . " " . $res->user->apellidos . "</strong> no pudo ser enviado. Error: " . $result)->error();
                    return redirect()->route('pqr.edit', $request->pqr_id);
                }
            } else {
                flash("No hay fecha disponible para realizar PQR. <strong>" . $fecha->fechainicio . " - " . $fecha->fechafin . "</strong>")->warning();
                return redirect()->route('pqr.index');
            }
        } else {
            flash("No hay fecha disponible para realizar PQR. <strong>" . $fecha->fechainicio . " - " . $fecha->fechafin . "</strong>")->warning();
            return redirect()->route('pqr.index');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store2(Request $request) {
        $fecha = Fechapqr::where('estado', 'ACTIVA')->first();
        if ($fecha != null) {
            $hoy = getdate();
            $a = $hoy["year"] . "-" . $hoy["mon"] . "-" . $hoy["mday"] . " " . $hoy["hours"] . ":" . $hoy["minutes"] . ":" . $hoy["seconds"];
            $h = strtotime($a);
            $fi = strtotime($fecha->fechainicio);
            $ff = strtotime($fecha->fechafin);
            if ($h >= $fi && $h <= $ff) {
                $pqr = new Pqr($request->all());
                $u = Auth::user();
                $pqr->user_id = $u->id;
                $pqr->asunto = strtoupper($pqr->asunto);
                $result = $pqr->save();
                if ($result) {
                    flash("La petición a <strong>" . $pqr->asunto . "</strong> fue enviada de forma exitosa. Esté atento a la respuesta.!")->success();
                    return redirect()->route('pqr.index');
                } else {
                    flash("La petición a <strong>" . $pqr->asunto . "</strong> no pudo ser enviada. Error: " . $result)->error();
                    return redirect()->route('pqr.index');
                }
            } else {
                flash("No hay fecha disponible para realizar PQR. <strong>" . $fecha->fechainicio . " - " . $fecha->fechafin . "</strong>")->warning();
                return redirect()->route('pqr.index');
            }
        } else {
            flash("No hay fecha disponible para realizar PQR. <strong>" . $fecha->fechainicio . " - " . $fecha->fechafin . "</strong>")->warning();
            return redirect()->route('pqr.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $pqr = Pqr::where('solicitud_id', $id)->first();
        if ($pqr == null) {
            $solicitud = Solicitud::find($id);
            return view('pqr.create')
                            ->with('location', 'pqr')
                            ->with('solicitud', $solicitud);
        } else {
            $res = $pqr->respuestas;
            return view('pqr.respuestas')
                            ->with('location', 'pqr')
                            ->with('res', $res)
                            ->with('pqr', $pqr);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $pqr = Pqr::find($id);
        $res = $pqr->respuestas;
        return view('pqr.respuestas')
                        ->with('location', 'pqr')
                        ->with('res', $res)
                        ->with('pqr', $pqr);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
