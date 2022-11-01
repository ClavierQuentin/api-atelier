<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePremiereBanniereRequest extends FormRequest
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
            'titre' => 'string|max:250',
            'texte' => 'string',
            'image'=>'image'
        ];
    }

    public function messages()
    {
        return [
            'string' => 'Ce champs doit être une chaîne de caractères !',
            'image'=>'Le fichier doit être une image'
        ];
    }
}
