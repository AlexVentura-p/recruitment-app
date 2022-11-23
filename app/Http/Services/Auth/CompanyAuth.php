<?php

namespace App\Http\Services\Auth;

use Illuminate\Database\Eloquent\Model;

interface CompanyAuth
{
    public function validate(Model $model);
}
