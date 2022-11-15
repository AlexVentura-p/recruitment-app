<?php

namespace Tests\Feature;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;
    use withFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_company_is_created()
    {
        $this->withoutMiddleware();

        $this->withHeader(
            'Accept',
            'application/json'
        )->post('api/admin/companies', [
            'name' => 'Applaudo',
            'description' => 'asdfasf'
        ]);

        $this->assertDatabaseHas('companies', [
            'name' => 'Applaudo'
        ]);
    }

    public function test_company_is_deleted()
    {

        $company = Company::factory()->create();

        $this->deleteJson('api/admin/companies/'.$company->name);

        $this->assertDatabaseMissing('companies', [
            'name' => $company->name,
        ]);
    }

    public function test_company_is_updated()
    {
        $company = Company::factory()->create([
            'name' => 'original'
        ]);
        $newAttributes = [
            'name' => $this->faker->name,
            'description' => $this->faker->sentence
        ];

        $this->putJson('api/admin/companies/'.$company->name,
            $newAttributes
        );
        $updatedProduct = Company::find($company->id);

        $this->assertEquals(
            $updatedProduct->name,
            $newAttributes['name']
        );

    }
}
