<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePremiereBanniereRequest extends FormRequest
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
            'titre' => 'required|string|max:250',
            'texte' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'titre.required' => 'Ce champs est obligatoire',
            'texte.required' => 'Ce champs est obligatoire',
            'titre.string' => 'Ce champs doit être une chaîne de caractères !',
            'texte.string' => 'Ce champs doit être une chaîne de caractères !'
        ];
    }
}
