<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class StageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $company = Company::all()->random();

        return [
            'name' => $this->faker->word,
            'company_id' => $company->id
        ];
    }
}
