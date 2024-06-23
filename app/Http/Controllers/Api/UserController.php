<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return response()->json($users);
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $authenticatedUser = Auth::user();
        if (!$authenticatedUser) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'company_id' => Auth::user()->company_id,
            'password' => Hash::make($request->get('password'))
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully.',
            'user' => $user
        ], 201);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }



    // public function edit(User $user): JsonResponse
    // {
    //     $roles = Role::pluck('name', 'name')->all();
    //     $userRoles = $user->roles->pluck('name', 'name')->all();
    //     return response()->json([
    //         'user' => $user,
    //         'roles' => $roles,
    //         'userRoles' => $userRoles
    //     ]);
    // }

    public function update(UpdateUserRequest $request, User $user)
    {
        // Use the validated data from the request
        $validatedData = $request->validated();

        // Update user with the validated data
        $user->update($validatedData);

        // Return the updated user
        return response()->json([
            'success' => true,
            'message' => 'User updated successfully.',
            'user' => $user
        ]);
    }



    public function destroy(User $user)
    {
        $authenticatedUser = Auth::user();
        if (!$authenticatedUser) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully.'
        ]);
    }
}
