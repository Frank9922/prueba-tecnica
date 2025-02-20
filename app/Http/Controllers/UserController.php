<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Services\ApiResponse;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : JsonResponse
    {
        try {

            $users = User::with('roles')->get();

            return ApiResponse::succes(['users' => $users]);

        } catch(\Exception $e) {

            return ApiResponse::error(['Error' => $e->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request) : JsonResponse
    {
        if(!$user = User::create($request->all())) return ApiResponse::error(['message' => 'No se pudo crear el nuevo usuario, intente mas tarde.']);

        return ApiResponse::succes(['user' => $user, 'message' => 'Se inserto correctamente el nuevo usuario.']);
    
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user) : JsonResponse
    {
        return ApiResponse::succes(['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user) : JsonResponse
    {           
        try {

            $user->fill($request->all());

            $user->update();

            return ApiResponse::succes(['user' => $user,'message' => 'Se actualizo correctamente el usuario.']);

        } catch(\Exception $e) {

            return ApiResponse::error(['Error: ' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user) : JsonResponse 
    {
        try {

            $user->delete();

            return ApiResponse::succes(['message' => 'Se elimino correctamente el usuario.']);

        } catch(\Exception $e) {

            return ApiResponse::error(['Error: ' => $e->getMessage()]);

        }
    }
}
