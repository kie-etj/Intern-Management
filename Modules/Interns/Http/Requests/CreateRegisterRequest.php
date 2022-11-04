<?php

namespace Modules\Interns\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateRegisterRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'firstname' => 'required',
            'lastname' => 'required',
            'dateofbirth' => 'required|date_format:Y-m-d|before:today',
            'email' => 'required',
            'phone' => 'required|numeric|digits:10',
            'school' => 'required',
            'faculty' => 'required',
            'studentid' => 'required',
        ];
    }

    public function translationRules()
    {
        return [];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [];
    }

    public function translationMessages()
    {
        return [];
    }
}
