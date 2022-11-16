<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobOpeningFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $company = Company::factory()->create();
        return [
            'company_id' => $company->id,
            'position' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'deadline' => $this->faker
                ->dateTimeBetween('now','+3 month')->format("Y-M-D H:m:s")
        ];
    }
}
