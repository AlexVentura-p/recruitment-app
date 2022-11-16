<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\JobOpening;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
        $jobOpeningInstance = JobOpening::factory()->make();

        $response = $this->postJson(
            'api/admin/job-openings',
            $jobOpeningInstance->getAttributes()
        );


        $this->assertDatabaseHas(
            'job_openings',
            json_decode($response->getContent(),true)
        );

    }
}
