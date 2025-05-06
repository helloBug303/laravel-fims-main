<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate the input fields
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
    
        // Get credentials from the request
        $credentials = $request->only('username', 'password');
        
        // Log the attempt (for debugging)
        Log::info('Login attempt', ['username' => $credentials['username']]);
        
        // Attempt authentication
        if (Auth::attempt($credentials)) {
            // Authentication passed
            Log::info('Login successful for user: ' . $credentials['username']);
            
            // Regenerate session
            $request->session()->regenerate();
            
            // Update last login time if needed
            $user = Auth::user();
            if (isset($user->last_login_at)) {
                $user->last_login_at = now();
                $user->save();
            }
            
            // Redirect to dashboard
            return redirect()->route('admin.dashboard');
        }
        
        // Authentication failed
        Log::info('Login failed for user: ' . $credentials['username']);
        
        return back()
            ->withErrors(['username' => 'The provided credentials do not match our records.'])
            ->withInput($request->except('password'));
    }

public function logout(Request $request)
{
    Auth::logout();
    
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    
    return redirect()->route('login');
}

    
    // Optional: Method to reset password for testing purposes
    public function resetTestPassword()
    {
        if (app()->environment('local')) {
            $user = User::where('username', 'admin')->first();
            if ($user) {
                $user->password = bcrypt('password123');
                $user->save();
                return "Password for admin reset to 'password123'";
            }
            return "User not found";
        }
        return "Not available in production";
    }
} 