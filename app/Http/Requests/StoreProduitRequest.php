<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProduitRequest extends FormRequest
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
            'nom_produit'=>'string|required|max:250',
            'description_courte_produit'=>'string|required',
            'description_longue_produit'=>'string|required',
            'prix_produit'=>'numeric|required',
            'isAccueil'=>'boolean',
            'categorie_id'=>'integer|required'
        ];
    }

    public function messages()
    {
        return [
            'nom_produit.string' => 'Doit être une chaîne de caractères',
            'description_courte_produit.string' => 'Doit être une chaîne de caractères',
            'description_longue_produit.string'=> 'Doit être une chaîne de caractères',
            'prix_produit.numeric' => 'Doit être au format nombre',
            'categorie_id.integer' => 'Doit être un nombre entier',
            'nom_produit.required' => 'Ce champ est requis',
            'description_courte_produit.required' => 'Ce champ est requis',
            'description_longue_produit.required'=> 'Ce champ est requis',
            'prix_produit.required' => 'Ce champ est requis',
            'categorie_id.required' => 'Ce champ est requis'
        ];
    }

}
