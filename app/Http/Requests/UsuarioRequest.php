<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest {

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
            'identificacion' => 'required|unique:users',
            'nombres' => 'required|max:250',
            'apellidos' => 'required|max:250',
            'email' => 'required|string|email|max:250',
            'password' => 'required|string|min:6',
            'estado' => 'required|max:50|min:5'
        ];
    }

}
