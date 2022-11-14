<?php

namespace Tests\Feature;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_company_is_created()
    {
        $this->withoutMiddleware();

        $response = $this->withHeader(
            'Accept',
            'application/json'
        )->post('api/admin/company',[
            'name' => 'Applaudo',
            'description' => 'asdfasf'
        ]);

        //dd($response);

        //$newCompany = Company::all()->where('name','=','Applaudo');
        //dd($newCompany);
        $this->assertDatabaseHas('companies',[
            'name' => 'Applaudo'
        ]);

    }
}
