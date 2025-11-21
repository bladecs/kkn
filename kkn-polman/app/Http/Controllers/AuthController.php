<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showAuthForm()
    {
        return view('auth_register.auth');
    }

    public function showAuthFormDosen()
    {
        return view('auth_register.auth_dosen');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!auth()->guard('web')->attempt($credentials)) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        $user = auth()->guard('web')->user();

        $request->session()->put('nim', $user->nim);

        $role = $user->role;

        switch ($role) {
            case 'mahasiswa':
                return redirect()->route('dashboard_mhs');
            default:
                Auth::logout();

                return redirect()->route('authForm')->with('error', 'Invalid user role.');
        }

    }

    public function loginDosen(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!auth()->guard('dosen')->attempt($credentials)) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        $user = auth()->guard('dosen')->user();

        $request->session()->put('nip', $user->nip);

        $role = $user->role;

        switch ($role) {
            case 'admin':
                return redirect()->route('dashboard_admin');
            case 'dosen':
                return redirect()->route('dashboard_dosen');
            case 'koordinator':
                return redirect()->route('dashboard_koordinator');
            default:
                Auth::guard('dosen')->logout();

                return redirect()->route('login-dosen')->with('error', 'Invalid user role.');
        }

    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'register-name' => 'required|string|max:255',
            'register-nim' => 'required|string|max:20|unique:users,nim',
            'register-email' => 'required|string|email|max:255|unique:users,email',
            'register-phone' => 'required|string|max:15',
            'register-jurusan' => 'required|string|max:100',
            'register-study-program' => 'required|string|max:100',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $user = User::create([
                'name' => $request->input('register-name'),
                'nim' => $request->input('register-nim'),
                'email' => $request->input('register-email'),
                'phone' => $request->input('register-phone'),
                'jurusan' => $request->input('register-jurusan'),
                'study_program' => $request->input('register-study-program'),
                'password' => bcrypt($request->input('password')),
            ]);

            return redirect()->route('authForm')->with('success', 'Registration successful. You can now log in.');
        } catch (\Exception $e) {
            \Log::error('Registration failed: '.$e->getMessage());

            return redirect()->back()->with('error', 'Registration failed: '.$e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        \Log::info('User logging out', ['user_id' => Auth::id()]);

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('authForm')->with('success', 'You have been logged out successfully.');
    }
}
