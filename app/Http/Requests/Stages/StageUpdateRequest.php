<?php

namespace App\Http\Requests\Stages;

use Illuminate\Foundation\Http\FormRequest;

class StageUpdateRequest extends FormRequest
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
            'name' => ['required', 'unique:stages,name,NULL,NULL,company_id,' . request('company_id')]
        ];
    }
}
