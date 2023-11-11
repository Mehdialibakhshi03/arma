<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Header2Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'=>'required|string:255',
            'number_1'=>'required|numeric',
            'number_2'=>'required|numeric',
            'number_3'=>'required|numeric',
            'priority'=>'required|numeric',
        ];
    }
}
