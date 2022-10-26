<?php

namespace Modules\Interns\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateIntern_DiaryRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
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
