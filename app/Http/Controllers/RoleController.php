<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Http\Services\ApiResponse;
use App\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();

        if($roles->isEmpty()) return ApiResponse::error(['message' => 'No se encontraron registros en la tabla roles.']);

        return ApiResponse::succes(['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        if(!$newRole = Role::create($request->all())) return ApiResponse::error(['message' => 'Hubo un error al registrar el nuevo rol, intente mas tarde.']);
        
        return ApiResponse::succes(['role' => $newRole, 'message' => 'Se inserto correctamente el nuevo rol']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return ApiResponse::succes(['role' => $role]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleUpdateRequest $request, Role $role)
    {
        try {

            $role->fill($request->all());

            $role->update();

            return ApiResponse::succes(['role' => $role, 'message' => 'Se actualizo correctamente el registro']);

        } catch(\Exception $e) {

            return ApiResponse::error(['Error: '=> $e->getMessage()]);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        try {

            $role->delete();

            return ApiResponse::succes(['message' => 'Se elimino correctamente el registro.']);

        } catch(\Exception $e) {

            return ApiResponse::error(['Error' => $e->getMessage()]);

        }
    }
}
