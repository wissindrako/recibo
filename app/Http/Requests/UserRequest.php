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
        $usuario = [
            'name' => ['string', 'max:255'],
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'is_ctive' => ['boolean'],
        ];
        $rol =  ['roles' =>  ['required', 'array', new ValidarUserRol]];

        return Arr::collapse([$usuario, $rol]);
    }
}
