<?php

namespace Modules\Interns\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateScheduleRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'student' => 'required',
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
