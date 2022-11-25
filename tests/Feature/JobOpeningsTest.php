<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\JobOpening;
use App\Models\Role;
use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class JobOpeningsTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_job_opening_can_be_created()
    {
        Role::factory()->create(['name' => 'admin']);
        Passport::actingAs(User::factory()->create(['role_id' => 1]));
        $company = Company::factory()->create();


        $response = $this->postJson(
            'api/admin/job-openings', [
                'company_name' => $company->name,
                'position' => 'manager',
                'description' => 'best place to work',
                'deadline' => '2022-11-25'
            ]);

        $this->assertDatabaseHas(
            'job_openings',
            json_decode($response->getContent(),true)
        );

    }
}
