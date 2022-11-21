<?php

namespace App\Http\Requests\Candidate;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangeStageRequest extends FormRequest
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
            'candidate_id' => ['required', Rule::exists('candidates', 'id')],
            'stage' => ['required', Rule::exists('stages', 'name')],
            'company_id' => ['required', Rule::exists('companies', 'id')]
        ];
    }
}
