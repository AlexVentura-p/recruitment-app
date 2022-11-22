<?php

namespace App\Http\Requests\JobOpening;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateJobOpeningRequest extends FormRequest
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
            'company_id' => ['required',Rule::exists('companies','id')],
            'position' => ['required'],
            'description' => ['required'],
            'deadline' => ['required']
        ];
    }
}
