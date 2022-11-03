<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewsletterRequest extends FormRequest
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
            'titre' => 'required|string|max:250',
            'body'=> 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Ce champ est obligatoire',
            'string' => 'Ce champ doit être une chaise de caractères',
        ];
    }
}
