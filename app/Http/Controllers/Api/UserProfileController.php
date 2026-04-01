<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\UserProfile;
use Illuminate\Http\Request;

// Modul: Shilla Maulida
class UserProfileController extends Controller
{
    // GET /api/user-profiles
    public function index()
    {
        $profiles = UserProfile::with('user')->get();
        return response()->json([
            'status'  => 'success',
            'message' => 'Data profil berhasil diambil',
            'data'    => $profiles
        ], 200);
    }

    // POST /api/user-profiles
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'     => 'required|exists:users,id|unique:user_profiles,user_id',
            'address'     => 'nullable|string',
            'city'        => 'nullable|string|max:100',
            'province'    => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'birth_date'  => 'nullable|date',
            'gender'      => 'nullable|in:male,female',
        ]);

        $profile = UserProfile::create($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Profil berhasil dibuat',
            'data'    => $profile->load('user')
        ], 201);
    }

    // GET /api/user-profiles/{id}
    public function show($id)
    {
        $profile = UserProfile::with('user')->find($id);

        if (!$profile) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Profil tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Data profil berhasil diambil',
            'data'    => $profile
        ], 200);
    }

    // PUT /api/user-profiles/{id}
    public function update(Request $request, $id)
    {
        $profile = UserProfile::find($id);

        if (!$profile) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Profil tidak ditemukan'
            ], 404);
        }

        $data = $request->validate([
            'address'     => 'nullable|string',
            'city'        => 'nullable|string|max:100',
            'province'    => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'birth_date'  => 'nullable|date',
            'gender'      => 'nullable|in:male,female',
        ]);

        $profile->update($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Profil berhasil diperbarui',
            'data'    => $profile
        ], 200);
    }

    // DELETE /api/user-profiles/{id}
    public function destroy($id)
    {
        $profile = UserProfile::find($id);

        if (!$profile) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Profil tidak ditemukan'
            ], 404);
        }

        $profile->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Profil berhasil dihapus'
        ], 200);
    }
}
