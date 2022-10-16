<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategorieRequest extends FormRequest
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
            'nom_categorie' => 'string|max:250',
        ];
    }

    public function messages()
    {
        return [
            'nom_categorie.string' => 'Ce champs doit être une chaîne de caractères !'
        ]
    }
}
