<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\Api\UserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return UserResource::collection(User::paginate(10))->additional([
            'status' => true,
            'message' => '',
            'token' => 'token',//auth token
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        //
        $data = $request->validated();

        $user = User::create($data);

        $user->roles()->attach($data['roles_id']);

        return (new UserResource($user))->additional([
            'status' => true,
            'message' => 'User Created Successfully',
            'token' => 'token',//auth token,
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
        return (new UserResource($user))->additional([
            'status' => true,
            'message' => '',
            'token' => 'token',//auth token,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        //
        $user->update($request->validated());

        $user->roles()->sync($request->roles_id);

        return response()->json([
            'status' => true,
            'message' => 'User Updated Successfully',
            'data' => [
                'token' => 'token',//auth token,
                'data' => new UserResource($user)
            ],
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
        $user->delete();

        return response()->json([
            'status' => true,
            'message' => 'User Deleted Successfully',
            'data' => [
                'token' => 'token',//auth token,
                'data' => []
            ],
        ],200);
    }
}
