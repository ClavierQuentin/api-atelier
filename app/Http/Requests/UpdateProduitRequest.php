<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProduitRequest extends FormRequest
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
            'nom_produit'=>'string',
            'description_courte_produit'=>'string',
            'description_longue_produit'=>'string',
            'prix_produit'=>'numeric',
            'categorie_id'=>'integer',
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
        ];
    }
}
