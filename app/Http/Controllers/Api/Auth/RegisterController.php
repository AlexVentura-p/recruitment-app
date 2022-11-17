<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{

    public function admin(Request $request)
    {
        $attributes = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:50', Rule::unique('users','email')],
            'password' => ['required', Rules\Password::defaults()],
            'role' => ['required'],
            'company_id' => ['nullable']
        ]);

        $role = Role::where('name','=',$attributes['role'])->first();

        $user = User::create([
            'first_name' => $attributes['first_name'],
            'last_name' => $attributes['last_name'],
            'email' => $attributes['email'],
            'password' => Hash::make($attributes['password']),
            'role_id' => $role->id,
            'company_id' => $attributes['company_id']
        ]);

        $token = $user->createToken('hiring-app')->accessToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response,201);
    }

    public function login(Request $request)
    {
        $attributes = $request->validate([
            'email' => ['required'],
            'password' => ['required']
        ]);


        if(Auth::attempt($attributes)){

            $user = User::where('email','=',$attributes['email'])->first();

            $token = $user->createToken('hiring-app')->accessToken;

            $response = [
                'token' => $token
            ];

            return response($response,201);
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response('Logged out');
    }

}
