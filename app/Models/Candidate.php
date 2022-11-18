<?php

namespace App\Models;

use http\Exception\InvalidArgumentException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function accept()
    {
        $this->status = 'Active';
    }

    public function reject()
    {
        $this->status = 'Rejected';
    }

    public function hire()
    {
        $this->status = 'Hired';
    }

    public function setStage(string $stage_name, int $company_id)
    {
        $stage = Stage::where('name', '=', $stage_name)
            ->where('company_id', '=', $company_id)->first();

        if ($stage ?? false) {
            $this->stage_id = $stage->id;
            $this->update();
            return $stage;
        }

        throw new InvalidArgumentException('Unregistered stage');
    }


}
