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
            'image'=>'required|image'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Ce champs est obligatoire',
            'string' => 'Ce champs doit être une chaîne de caractères !',
            'image'=>'Le fichier doit être une image'
        ];
    }
}
