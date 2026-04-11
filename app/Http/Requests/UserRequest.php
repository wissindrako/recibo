<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\ValidarUserRol;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $user   = $this->route('user');
        $userId = $user instanceof \App\Models\User ? $user->id : $user;

        $usuario = [
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255', Rule::unique(User::class)->ignore($userId)],
            'is_active' => ['boolean'],
        ];
        $rol = ['roles' => ['required', 'array', new ValidarUserRol]];

        return Arr::collapse([$usuario, $rol]);
    }

    public function messages()
    {
        return [
            'name.required'    => 'El nombre es obligatorio.',
            'name.max'         => 'El nombre no puede superar los 255 caracteres.',
            'email.required'   => 'El correo electrónico es obligatorio.',
            'email.email'      => 'El correo electrónico no tiene un formato válido.',
            'email.max'        => 'El correo no puede superar los 255 caracteres.',
            'email.unique'     => 'Este correo ya está en uso por otro usuario.',
            'roles.required'   => 'Debe asignar al menos un rol.',
            'roles.array'      => 'El campo roles debe ser un arreglo.',
        ];
    }
}
