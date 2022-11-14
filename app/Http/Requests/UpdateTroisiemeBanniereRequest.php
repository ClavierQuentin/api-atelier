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
            'titre_principal' => 'string|max:250',
            'titre_1'=>'string|max:250',
            'titre_2'=>'string|max:250',
            'texte_1'=>'string',
            'texte_2'=>'string',
        ];
    }

    public function messages()
    {
        return [
            'string' => 'Ce champs doit être une chaîne de caractères !',
        ];
    }

}
