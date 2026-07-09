<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    

    public function authorize(): bool
    {
        return true;
    }

    

    public function rules(): array
    {
        return [
            'email' => [
                'required', 
                'string', 
                'email',
                function ($attribute, $value, $fail) {
                    if (!str_ends_with($value, '@telkomsel.id')) {
                        $fail('Hanya email dengan domain perusahaan (@telkomsel.id) yang diperbolehkan.');
                    }
                }
            ],
            'password' => ['required', 'string'],
        ];
    }

    

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        $user = Auth::user();
        $name = strtolower($user->name);

        if (str_contains($name, 'admin')) {
            $role = \App\Models\Role::firstOrCreate(['name' => 'admin']);
            $user->update(['role_id' => $role->id]);
        } elseif (str_contains($name, 'staff')) {
            $role = \App\Models\Role::firstOrCreate(['name' => 'staff']);
            $user->update(['role_id' => $role->id]);
        } elseif (str_contains($name, 'manager')) {
            $role = \App\Models\Role::firstOrCreate(['name' => 'manager']);
            $user->update(['role_id' => $role->id]);
        } else {
            Auth::logout();
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => 'Akses ditolak. Nama akun Anda harus mengandung kata "admin", "staff", atau "manager".',
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    

    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    

    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
