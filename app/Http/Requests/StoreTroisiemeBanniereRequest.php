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
            'texte_2'=>'required|string'
        ];
    }

    public function messages()
    {
        return [
            'titre_principal.required' => 'Ce champs est obligatoire',
            'titre_1.required'=>'Ce champs est obligatoire',
            'titre_2.required'=>'Ce champs est obligatoire',
            'texte_1.required'=>'Ce champs est obligatoire',
            'texte_2.required'=>'Ce champs est obligatoire',
            'titre_principal.string' => 'Ce champs doit �tre une cha�ne de caract�res',
            'titre_1.string'=>'Ce champs doit �tre une cha�ne de caract�res',
            'titre_2.string'=>'Ce champs doit �tre une cha�ne de caract�res',
            'texte_1.string'=>'Ce champs doit �tre une cha�ne de caract�res',
            'texte_2.string'=>'Ce champs doit �tre une cha�ne de caract�res'
        ];
    }
}
