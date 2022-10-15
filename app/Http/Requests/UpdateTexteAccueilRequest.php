<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTexteAccueilRequest extends FormRequest
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
            'titre_accueil' =>'string|max:250',
            'texte_accueil'=>'string',
            'titre_categories' =>'string|max:250',
        ];
    }

    public function messages()
    {
        return [
            'titre_accueil.string'=>'Ce champ doit être une chaîne de caractères',
            'texte_accueil.string'=>'Ce champ doit être une chaîne de caractères',
            'titre_categories.string'=>'Ce champ doit être une chaîne de caractères'
        ];
    }

}
