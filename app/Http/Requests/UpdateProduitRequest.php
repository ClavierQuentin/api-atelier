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
            'isAccueil'=>'boolean',
            'categorie_id'=>'integer'
        ];
    }

    public function messages()
    {
        return [
            'nom_produit.string' => 'Doit �tre une cha�ne de caract�res',
            'description_courte_produit.string' => 'Doit �tre une cha�ne de caract�res',
            'description_longue_produit.string'=> 'Doit �tre une cha�ne de caract�res',
            'prix_produit.numeric' => 'Doit �tre au format nombre',
            'categorie_id.integer' => 'Doit �tre un nombre entier'
        ];
    }
}
