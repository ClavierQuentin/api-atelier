<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarrouselRequest extends FormRequest
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
            'texte'=>'required|string',
            'bouton'=>'required|string|max:50'
        ];
    }

    public function messages()
    {
        return [
            'required'=>'Ce champs est obligatoire',
            'string'=>'Ce champs doit être une chaine de caractères',
            'max'=>'Doit contenir que 20 caractères'
        ];
    }
}
