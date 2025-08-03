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
            
            $user = User::where('email', $googleUser->getEmail())->first();

if (!$user) {
    $user = new User();
    $user->name = $googleUser->getName();
    $user->email = $googleUser->getEmail();
    $user->password = bcrypt(Str::random(16));
    $user->rol = 'cliente'; // el mutador lo convierte en "Cliente"
    $user->save();
}

            Auth::login($user, true);
            $user->refresh();

            // Redireccionar según rol:
        if ($user->rol === 'Admin') {
            return redirect()->route('admin.home'); 
        } elseif ($user->rol === 'Empleado') {
            return redirect()->route('empleado.home');
        } else {
            return redirect()->route('cliente.home');
        }

        } catch (\Exception $e) {
            return redirect('/login')->withErrors('Error al iniciar sesión con Google.');
        }
    }
}
