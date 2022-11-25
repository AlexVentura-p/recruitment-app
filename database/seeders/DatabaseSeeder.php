<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\Company;
use App\Models\JobOpening;
use App\Models\Role;
use App\Models\Stage;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::factory()->create(['name' => 'admin']);
        $adminCompanyRole = Role::factory()->create(['name' => 'admin-company']);
        $recruiterRole = Role::factory()->create(['name' => 'recruiter']);
        $candidateRole = Role::factory()->create(['name' => 'candidate']);

        $userAdmin = User::factory()->create([
            'role_id' => $adminRole->id,
            'first_name'   =>  'alex',
            'last_name' => 'ventura',
            'email' => 'av@gmail.com',
            'password' => Hash::make('12345678')
        ]);

        $companies = Company::factory(5)->create();

        Stage::factory(20)->create();

        foreach ($companies as $company){
            User::factory(2)->create([
                'role_id' => $adminCompanyRole->id,
                'company_id' => $company->id
            ]);

            User::factory(2)->create([
                'role_id' => $recruiterRole->id,
                'company_id' => $company->id
            ]);
        }


        Candidate::factory(20)->create();

    }
}
