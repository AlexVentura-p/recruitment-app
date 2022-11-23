<?php

namespace Tests\Feature;

use App\Models\JobOpening;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class JobApplicationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_new_job_application_can_be_created()
    {
        Role::factory()->create(['name' => 'candidate']);
        Passport::actingAs(User::factory()->create(['role_id' => 1]));
        $jobOpening = JobOpening::factory()->create();
        $response = $this->postJson('api/candidates',[
            'job_opening_id' => $jobOpening->id
        ]);

        $response->assertStatus(201);
    }
}
