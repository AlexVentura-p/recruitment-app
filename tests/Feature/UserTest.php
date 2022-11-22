<?php

namespace Tests\Feature;

use App\Http\Services\RateConverter\RateConverter;
use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;
use Tests\Fakes\FakeEURConverter;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::factory()->create(['name' => 'admin']);
        Role::factory()->create(['name' => 'admin-company']);
        Role::factory()->create(['name' => 'recruiter']);
        Role::factory()->create(['name' => 'candidate']);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_user()
    {
        $roleAdmin = Role::where('name','=','admin')->first();

        Passport::actingAs(User::factory()->create([
            'role_id' => $roleAdmin->id
        ]));
        $company = Company::factory()->create();

        $roleRecruiter = Role::where('name','=','recruiter')->first();

        //dd($user->getAttributes());

        $response = $this->postJson('api/admin/register',[
            'first_name' => 'alex',
            'last_name' => 'perez',
            'email' => 'a@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'recruiter',
            'company_id' => $company->id
        ]);

        dd($response);
    }
}
