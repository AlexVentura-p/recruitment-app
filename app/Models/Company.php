<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;
    public $guarded = [];

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function job_openings(): HasMany
    {
        return $this->hasMany(JobOpening::class);
    }

    public function stages(): HasMany
    {
        return $this->hasMany(Stage::class);
    }
}
