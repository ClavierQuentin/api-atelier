<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCarrouselRequest extends FormRequest
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
            'texte'=>'string',
            'bouton'=>'string|max:50'
        ];
    }

    public function messages()
    {
        return [
            'string'=>'Ce champs doit être une chaine de caractères',
            'max'=>'Doit contenir que 20 caractères'
        ];
    }
}
