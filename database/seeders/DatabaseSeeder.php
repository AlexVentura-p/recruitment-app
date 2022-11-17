<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Role::factory()->create([
            'name'  => 'admin'
        ]);

        Role::factory()->create([
            'name'  => 'admin-company'
        ]);

        Role::factory()->create([
            'name'  => 'recruiter'
        ]);

        Role::factory()->create([
            'name'  => 'candidate'
        ]);
    }
}
