<?php

namespace Database\Factories;

use App\Models\JobOpening;
use App\Models\Role;
use App\Models\Stage;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CandidateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $jobOpening = JobOpening::factory()->create();
        $role = Role::where('name','=','candidate')->first();
        $user = User::factory()->create([
            'role_id' => $role->id
        ]);

        return [
            'job_opening_id' => $jobOpening->id,
            'user_id'   => $user->id,
            'status' => $this->faker->randomElement(['Pending review'])
        ];
    }
}
