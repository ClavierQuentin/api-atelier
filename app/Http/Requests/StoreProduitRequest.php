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
            'prix_produit'=>'numeric|required|max:250',
            'isAcceuil'=>'boolean|required'
        ];
    }
}
