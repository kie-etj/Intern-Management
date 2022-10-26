<?php

namespace Modules\Interns\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateSchoolRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'shortname' => 'required',
            'fullname' => 'required',
            'webpage' => 'required',
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
