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
            'nom_produit'=>'required|string|max:250',
            'description_courte_produit'=>'required|string',
            'description_longue_produit'=>'required|string',
            'prix_produit'=>'required|numeric',
            'categorie_id'=>'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'required'=> "Ce champs est obligatoire",
            'string' => 'Ce champs doit être une chaine de caractère',
            'numeric'=> "Doit être au format nombre",
            'integer'=> 'Il faut choisir une catégorie',
        ];
    }

}
