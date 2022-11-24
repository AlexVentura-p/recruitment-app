<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StageReportTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_pdf_report_per_stage_receives_data()
    {
        $this->withoutMiddleware();
        $response = $this->get('api/reports',[
            'stage' => 'interview'
        ]);
        dd($response);
        $response->assertStatus(200);
    }
}
