<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'logo'=>'nullable|image',
            'favicon'=>'nullable|image',
            'robot_index'=>'nullable',
            'meta_description'=>'nullable|string',
            'meta_title'=>'nullable|string',
            'title'=>'nullable|string',
        ];
    }
}
