<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategorieRequest extends FormRequest
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
            'nom_categorie' =>'required|string',
            'image'=>'required|image'
        ];
    }

    public function messages()
    {
        return [
            'required'=>'Ce champ est obligatoire !',
            'string'=>'Ce champ doit être une chaine de caractères',
            'image'=>'Le fichier doit être une image'
        ];
    }
}
