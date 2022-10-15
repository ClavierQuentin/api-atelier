<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTexteAccueilRequest extends FormRequest
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
            'titre_accueil' =>'required|string|max:250',
            'texte_accueil'=>'required|string',
            'titre_categories' =>'required|string|max:250'
        ];
    }
    public function messages()
    {
        return [
            'titre_accueil.required'=>'Ce champ est obligatoire',
            'titre_accueil.string'=>'Ce champ doit être une chaîne de caractères',
            'texte_accueil.required'=>'Ce champ est obligatoire',
            'texte_accueil.string'=>'Ce champ doit être une chaîne de caractères',
            'titre_categories.required'=>'Ce champ est obligatoire',
            'titre_categories.string'=>'Ce champ doit être une chaîne de caractères',
        ];
    }
}
