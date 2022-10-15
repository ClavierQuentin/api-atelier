<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDeuxiemeBanniereRequest extends FormRequest
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
        return [
            'titre' =>  'string|max:250',
            'texte' => 'string'
        ];
    }

    public function messages()
    {
        return [
            'titre.string' => 'Ce champs doit être une chaîne de caractères !',
            'texte.string' => 'Ce champs doit être une chaîne de caractères !'
        ];
    }

}
