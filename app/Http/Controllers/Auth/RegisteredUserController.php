<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    

    public function create(): View
    {
        return view('auth.register');
    }

    

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 
                'string', 
                'lowercase', 
                'email', 
                'max:255', 
                'unique:'.User::class,
                function ($attribute, $value, $fail) {
                    if (!str_ends_with($value, '@telkomsel.id')) {
                        $fail('Hanya email dengan domain perusahaan (@telkomsel.id) yang diperbolehkan.');
                    }
                }
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $name = strtolower($request->name);
        $roleName = null;

        if (str_contains($name, 'admin')) {
            $roleName = 'admin';
        } elseif (str_contains($name, 'staff')) {
            $roleName = 'staff';
        } elseif (str_contains($name, 'manager')) {
            $roleName = 'manager';
        } else {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'name' => 'Akses ditolak. Nama akun Anda harus mengandung kata "admin", "staff", atau "manager".',
            ]);
        }

        $assignedRole = \App\Models\Role::firstOrCreate(['name' => $roleName]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $assignedRole->id,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
