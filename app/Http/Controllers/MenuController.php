<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller {

    /**
     * Show the view menu usuarios.
     *
     * @return \Illuminate\Http\Response
     */
    public function usuarios() {
        return view('menu.usuarios')->with('location', 'usuarios');
    }

    /**
     * Show the view menu solicitud.
     *
     * @return \Illuminate\Http\Response
     */
    public function solicitud() {
        return view('menu.solicitud')->with('location', 'solicitud');
    }

    /**
     * Show the view menu pqr.
     *
     * @return \Illuminate\Http\Response
     */
    public function pqr() {
        return view('menu.pqr')->with('location', 'pqr');
    }

    /**
     * Show the view menu reporte.
     *
     * @return \Illuminate\Http\Response
     */
    public function reporte() {
        return view('menu.reportes')->with('location', 'reporte');
    }

}
