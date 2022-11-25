<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class CandidateUserController extends Controller
{

    private Role $candidateRole;

    /**
     * @param Role $candidateRole
     */
    public function __construct()
    {
        $this->candidateRole = Role::where('name','=','candidate')->first();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(
            User::where('role_id','=',$this->candidateRole->id)->get()
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {

        if ($user->role->name != 'candidate'){
            return response(['message' => 'Forbidden'], 403);
        }
        return response($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        if ($user->role->name != 'candidate'){
            return response(['message' => 'Forbidden'], 403);
        }

        $attributes = $request->validated();

        $user->update($attributes);

        return response($user);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->role->name != 'candidate'){
            return response(['message' => 'Forbidden'], 403);
        }
        $user->delete();
        return response('No content', 204);
    }
}
