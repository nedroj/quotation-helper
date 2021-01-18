<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmailFormRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'default_recipient' => ['bail', 'nullable', 'email', 'max:255'],
            'subject'           => ['bail', 'required', 'max:255'],
            'body'              => ['bail', 'required'],
        ];
    }
}
