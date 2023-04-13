<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocenteRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'tipodoc' => 'required',
            'numero_documento' => 'required|max:15',
            'primer_nombre' => 'required|max:50',
            'primer_apellido' => 'required|max:50',
            'correo' => 'required',
            'departamentof_id' => 'required',
            'categoria_id' => 'required'
        ];
    }

}
