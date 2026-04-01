<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

// Modul: Rafani Wasi'unnikmah Siregar
class UserController extends Controller
{
    // GET /api/users
    public function index()
    {
        $users = User::with('profile')->get();
        return response()->json([
            'status'  => 'success',
            'message' => 'Data users berhasil diambil',
            'data'    => $users
        ], 200);
    }

    // POST /api/users
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'role'  => 'nullable|in:customer,admin',
        ]);

        $user = User::create($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'User berhasil dibuat',
            'data'    => $user
        ], 201);
    }

    // GET /api/users/{id}
    public function show($id)
    {
        $user = User::with('profile', 'orders')->find($id);

        if (!$user) {
            return response()->json([
                'status'  => 'error',
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Data user berhasil diambil',
            'data'    => $user
        ], 200);
    }

    // PUT /api/users/{id}
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status'  => 'error',
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        $data = $request->validate([
            'name'  => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'role'  => 'nullable|in:customer,admin',
        ]);

        $user->update($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'User berhasil diperbarui',
            'data'    => $user
        ], 200);
    }

    // DELETE /api/users/{id}
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status'  => 'error',
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'User berhasil dihapus'
        ], 200);
    }
}
