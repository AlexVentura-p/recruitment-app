<?php

namespace App\Http\Services\Auth;

use Illuminate\Database\Eloquent\Model;

interface ChangeValidator
{
    public function validate(Model $model);
}
