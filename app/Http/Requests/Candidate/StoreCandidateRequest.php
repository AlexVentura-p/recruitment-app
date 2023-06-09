<?php

namespace App\Http\Requests\Candidate;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCandidateRequest extends FormRequest
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
            'job_opening_id' => [
                'required',
                Rule::exists('job_openings', 'id'),
                'unique:candidates,job_opening_id,NULL,NULL,user_id,' . auth()->user()->id]

        ];
    }
}
