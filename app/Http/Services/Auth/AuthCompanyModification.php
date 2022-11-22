<?php

namespace App\Http\Services\Auth;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;

class AuthCompanyModification implements ChangeValidator
{
    public function validate(Model $company) : bool
    {
        if (auth()->user()->role->name == 'admin') {
            return true;
        }

        if (auth()->user()->company_id == $company->id) {
            return true;
        }

        return false;
    }
}
