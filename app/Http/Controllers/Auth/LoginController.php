<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        // If user is already logged in, redirect to dashboard
        if (auth()->check() && auth()->user()->hasAdminAccess()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.login');
    }

    /**
     * Handle a login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Attempt to authenticate using username or email
        $field = filter_var($credentials['username'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        
        if (Auth::attempt([$field => $credentials['username'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            $user = Auth::user();

            // Check if user is blocked
            if ($user->isBlocked()) {
                Auth::logout();
                return back()->withErrors([
                    'username' => 'Your account has been blocked. Please contact administrator.',
                ])->onlyInput('username');
            }

            // Check if user is active
            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors([
                    'username' => 'Your account is not active. Please wait for approval.',
                ])->onlyInput('username');
            }

            // Check if user has admin access (super_admin or admin)
            if (!$user->hasAdminAccess()) {
                Auth::logout();
                return back()->withErrors([
                    'username' => 'You do not have permission to access the admin dashboard.',
                ])->onlyInput('username');
            }

            // Redirect to dashboard
            return redirect()->intended(route('admin.dashboard'));
        }

        throw ValidationException::withMessages([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Log the user out.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

