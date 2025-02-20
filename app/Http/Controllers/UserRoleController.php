<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRoleRequest;
use App\Http\Services\ApiResponse;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

     }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRoleRequest $request)
{
    try {
        $user = User::findOrFail($request->user_id);

        // Si el array de role_ids está vacío, desasociamos los roles del usuario
        if (empty($request->role_ids)) {
            $user->roles()->detach(); // Eliminar todos los roles del usuario
        } else {
            $user->roles()->sync($request->role_ids); // Sincronizar los roles con los IDs enviados
        }

        // Crear los registros de UserRole si no existen
        foreach($request->role_ids as $roleId) {
            UserRole::firstOrCreate([
                'user_id' => $request->user_id,
                'role_id' => $roleId
            ]);
        }

        // Obtener los roles asignados utilizando el campo 'roles.id' para evitar ambigüedad
        $assignedRoles = $user->roles()->whereIn('roles.id', $request->role_ids)->get();

        return ApiResponse::succes(['assignedRoles' => $assignedRoles, 'message' => 'Se asignaron correctamente los roles al usuario.']);
    } catch(\Exception $e) {
        return ApiResponse::error(['Error: ' => $e->getMessage()]);
    }
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
