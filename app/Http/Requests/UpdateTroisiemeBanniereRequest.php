<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTroisiemeBanniereRequest extends FormRequest
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
            'titre_principal' => 'string:250',
            'titre_1'=>'string:250',
            'titre_2'=>'string:250',
            'texte_1'=>'string',
            'texte_2'=>'string'
        ];
    }

    public function messages()
    {
        return [
            'titre_principal.string' => 'Ce champs doit �tre une cha�ne de caract�res',
            'titre_1.string'=>'Ce champs doit �tre une cha�ne de caract�res',
            'titre_2.string'=>'Ce champs doit �tre une cha�ne de caract�res',
            'texte_1.string'=>'Ce champs doit �tre une cha�ne de caract�res',
            'texte_2.string'=>'Ce champs doit �tre une cha�ne de caract�res'
        ];
    }

}
