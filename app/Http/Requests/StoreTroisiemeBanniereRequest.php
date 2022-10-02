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
            'titre_principal' => 'required|string:250',
            'titre_1'=>'required|string:250',
            'titre_2'=>'required|string:250',
            'texte_1'=>'required|string',
            'texte_2'=>'required|string'
        ];
    }
}
