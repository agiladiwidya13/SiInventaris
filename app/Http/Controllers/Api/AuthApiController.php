<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthApiController extends Controller
{
    

    public function login(Request $request)
    {
        $request->validate([
            'email' => [
                'required', 
                'email',
                function ($attribute, $value, $fail) {
                    if (!str_ends_with($value, '@telkomsel.id')) {
                        $fail('Hanya email dengan domain perusahaan (@telkomsel.id) yang diperbolehkan.');
                    }
                }
            ],
            'password' => 'required',
            'device_name' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Kredensial yang diberikan salah.'],
            ]);
        }

        $name = strtolower($user->name);
        $roleName = null;

        if (str_contains($name, 'admin')) {
            $roleName = 'admin';
        } elseif (str_contains($name, 'staff')) {
            $roleName = 'staff';
        } elseif (str_contains($name, 'manager')) {
            $roleName = 'manager';
        } else {
            throw ValidationException::withMessages([
                'email' => ['Akses ditolak. Nama akun Anda harus mengandung kata "admin", "staff", atau "manager".'],
            ]);
        }

        $role = \App\Models\Role::firstOrCreate(['name' => $roleName]);
        $user->update(['role_id' => $role->id]);

        $token = $user->createToken($request->device_name)->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role->name ?? null,
            ]
        ]);
    }

    

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Berhasil logout dari API.']);
    }
}
