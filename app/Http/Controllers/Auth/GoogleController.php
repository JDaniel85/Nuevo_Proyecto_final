<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'password' => bcrypt(Str::random(16)),
                    'rol' => 'Cliente',
                ]
            );

            Auth::login($user, true);

            // Redireccionar según rol:
        if ($user->rol === 'Admin') {
            return redirect()->route('admin.dashboard'); 
        } elseif ($user->rol === 'Empleado') {
            return redirect()->route('empleado.dashboard');
        } else {
            return redirect()->route('cliente.dashboard');
        }

        } catch (\Exception $e) {
            return redirect('/login')->withErrors('Error al iniciar sesión con Google.');
        }
    }
}
