<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    

    /**
     * Create a new controller instance.
     *
     * @return void
     */

     /**
     * Handle a login request to the application.
     */
    protected function authenticated(Request $request, $user)
    {
        $this->logUserAction($user, 'Inició sesión');
        return redirect()->intended($this->redirectPath());
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        
        if ($user) {
            $this->logUserAction($user, 'Cerró sesión');
        }
        
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
    
    /**
     * Log user authentication actions
     */
    private function logUserAction($user, string $action)
    {
        $logMessage = sprintf(
            "[%s] Usuario: %s (ID: %d, Rol: %s) - Acción: %s",
            Carbon::now()->format('Y-m-d H:i:s'),
            $user->name,
            $user->id,
            $user->rol ?? 'Sin rol',
            $action
        );
        
        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/acciones.log'),
        ])->info($logMessage);
    }


    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
