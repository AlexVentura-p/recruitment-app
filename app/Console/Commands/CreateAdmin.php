<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a user admin';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $first_name = $this->ask('Enter first name');
        $last_name = $this->ask('Enter last name');
        $email = $this->ask('Enter email');

        if (User::where('email', '=', $email)->count() > 0) {
            $this->info('Email already taken. Execute again and try another email.');
            return 0;
        }

        $password = $this->secret('Enter new password');
        $role = Role::where('name','=','admin')->first();

        if ($this->confirm('Do you wish to continue?')) {
            $user = User::create([
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'password' => Hash::make($password),
                'role_id' => $role->id
            ]);
            $this->info('New user admin created!!');
        }

        return 0;
    }
}
