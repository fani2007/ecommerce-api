<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    // GET /api/users
    public function index(): JsonResponse
    {
        $users = User::with('profile')->get();
        return response()->json([
            'success' => true,
            'data'    => $users,
        ]);
    }

    // GET /api/users/{id}
    public function show(int $id): JsonResponse
    {
        $user = User::with('profile')->find($id);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User tidak ditemukan'], 404);
        }

        return response()->json(['success' => true, 'data' => $user]);
    }

    // POST /api/users
    public function store(Request $request): JsonResponse
    {
        $data = $request->only(['name', 'email', 'phone', 'password', 'role']);

        if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
            return response()->json(['success' => false, 'message' => 'name, email, dan password wajib diisi'], 422);
        }

        if (User::where('email', $data['email'])->exists()) {
            return response()->json(['success' => false, 'message' => 'Email sudah terdaftar'], 409);
        }

        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);

        UserProfile::create(['user_id' => $user->id]);

        return response()->json(['success' => true, 'message' => 'User berhasil dibuat', 'data' => $user->load('profile')], 201);
    }

    // PUT /api/users/{id}
    public function update(Request $request, int $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User tidak ditemukan'], 404);
        }

        $user->update($request->only(['name', 'phone', 'role']));

        if ($request->hasAny(['address', 'city', 'province', 'postal_code', 'birth_date', 'avatar'])) {
            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                $request->only(['address', 'city', 'province', 'postal_code', 'birth_date', 'avatar'])
            );
        }

        return response()->json(['success' => true, 'message' => 'User berhasil diupdate', 'data' => $user->load('profile')]);
    }

    // DELETE /api/users/{id}
    public function destroy(int $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User tidak ditemukan'], 404);
        }

        $user->delete();
        return response()->json(['success' => true, 'message' => 'User berhasil dihapus']);
    }
}
