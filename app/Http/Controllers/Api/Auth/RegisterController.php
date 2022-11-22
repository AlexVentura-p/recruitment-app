<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{

    public function register(StoreUserRequest $request)
    {
        $attributes = $request->validated();

        if (request('role') == 'admin') {
            if (auth()->user()->role->name == 'admin') {
                $attributes['company_id'] = null;
                return $this->store($attributes,[]);
            }
        }

        if (request('role') == 'admin-company') {
            if (auth()->user()->role->name == 'admin' ||
                auth()->user()->tokenCan('crud_admin_company')) {
                $scopes = ['crud_recruiters','crud_candidates'];
                return $this->store($attributes,$scopes);
            }
        }

        if (request('role') == 'recruiter') {
            if (auth()->user()->role->name == 'admin' ||
                auth()->user()->tokenCan('crud_recruiters')) {
                $scopes = ['crud_candidates'];
                return $this->store($attributes,$scopes);
            }
        }

        return response(['message' => 'Forbidden'], 403);
    }

    public function registerCandidate(StoreUserRequest $request)
    {
        $attributes = $request->validated();

        if (request('role') == 'candidate') {
            $attributes['company_id'] = null;
            return $this->store($attributes,[]);
        }
    }


    public function store($attributes,array $scopes)
    {
        $role = Role::where('name', '=', $attributes['role'])->first();
        $attributes['password'] = Hash::make($attributes['password']);
        unset($attributes['role']);
        $attributes['role_id'] = $role->id;
        $user = User::create($attributes);

        $token = $user->createToken('hiring-app',$scopes)->accessToken;

        return response([
            'user' => $user,
            'token' => $token
        ],201);
    }

    public function login(Request $request)
    {
        $attributes = $request->validate([
            'email' => ['required'],
            'password' => ['required']
        ]);


        if (Auth::attempt($attributes)) {
            $user = User::where('email', '=', $attributes['email'])->first();

            $token = $user->createToken('hiring-app')->accessToken;

            $response = [
                'token' => $token
            ];

            return response($response, 201);
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response('Logged out');
    }


}
