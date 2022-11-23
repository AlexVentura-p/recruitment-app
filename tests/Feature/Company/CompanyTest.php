<?php

namespace Company;

use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
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
        Role::factory()->create(['name' => 'admin']);
        Passport::actingAs(User::factory()->create(['role_id' => 1]));
        $company = Company::factory()->create();

        $response = $this->deleteJson('api/admin/companies/'.$company->name);

        $this->assertDatabaseMissing('companies', [
            'name' => $company->name,
        ]);
    }

    public function test_company_is_updated()
    {
        Role::factory()->create(['name' => 'admin']);
        Passport::actingAs(User::factory()->create(['role_id' => 1]));

        $company = Company::factory()->create([
            'name' => 'original',
            'description' => 'des1'
        ]);
        $newAttributes = [
            'name' => 'modified',
            'description' => 'des2'
        ];

        $response = $this->putJson('api/admin/companies/'.$company->name,
            $newAttributes
        );


        $updatedCompany = Company::find($company->id)->first();

        $this->assertEquals(
            $newAttributes['name'],
            $updatedCompany->name
        );

    }
}
