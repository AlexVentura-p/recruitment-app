<?php

namespace App\Http\Requests\Reports;

use App\Models\Stage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StageReportRequest extends FormRequest
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
            'stage' => ['required','exists:stages,name,company_id,' . request('company_id')],
            'company_id' => ['required','exists:stages,company_id,name,' . request('stage')]
        ];
    }
}
