<?php

namespace App\Models;

use http\Exception\InvalidArgumentException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function accept()
    {
        $this->status = 'Active';
    }

    public function deny()
    {
        $this->status = 'Denied';
    }

    public function finish()
    {
        $this->status = 'completed';
    }

    public function setStage(string $stage, int $company_id)
    {
        if (Stage::where('name', '=', $stage)->where('company_id', '=', $company_id)) {
            $this->stage = $stage;
        }

        throw new InvalidArgumentException('Unregistered stage');
    }


}
