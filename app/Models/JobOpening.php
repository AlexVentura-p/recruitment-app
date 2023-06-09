<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobOpening extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function company() : BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function candidate()
    {
        return $this->hasMany(Candidate::class);
    }
}
