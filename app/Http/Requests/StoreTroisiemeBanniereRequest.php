<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTroisiemeBanniereRequest extends FormRequest
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
            'titre_principal' => 'required|string|max:250',
            'titre_1'=>'required|string|max:250',
            'titre_2'=>'required|string|max:250',
            'texte_1'=>'required|string',
            'texte_2'=>'required|string',
            'image'=>'required|image',
            'image2'=>'required|image'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Ce champs est obligatoire',
            'string' => 'Ce champs doit être une chaîne de caractères !',
            'image' => "Le fichier doit être une image"
        ];
    }
}
