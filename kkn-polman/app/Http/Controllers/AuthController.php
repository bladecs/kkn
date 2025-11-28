<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showAuthForm()
    {
        $jurusan = Jurusan::all();

        return view('auth_register.auth', compact('jurusan'));
    }

    public function getProdi($jurusan_id)
    {
        $prodi = Prodi::where('jurusan_id', $jurusan_id)->get();

        return response()->json($prodi);
    }

    public function login(Request $request)
    {
        try {

            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            if (!Auth::attempt($credentials)) {
                return back()->withErrors([
                    'email' => 'The provided credentials do not match our records.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();

            $user = Auth::user();

            $request->session()->put('id', $user->id);

            $role = $user->role;

            switch ($role) {
                case 'mahasiswa':
                    return redirect()->route('dashboard_mhs');

                case 'admin':
                    return redirect()->route('dashboard_admin');

                case 'dosen':
                    return redirect()->route('dashboard_dosen');

                case 'koordinator':
                    return redirect()->route('dashboard_koordinator');

                default:
                    Auth::logout();

                    return redirect()->route('authForm')
                        ->with('error', 'Invalid user role.');
            }

        } catch (\Exception $e) {
            Auth::logout();

            return redirect()->route('authForm')
                ->with('error', 'Login failed: '.$e->getMessage());
        }
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'register-name' => 'required|string|max:255',
            'register-nim' => 'required|string|max:20|unique:mahasiswa,nim',
            'register-email' => 'required|string|email|max:255|unique:users,email',
            'register-jurusan' => 'required|string|max:100',
            'register-prodi' => 'required|string|max:100',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            DB::beginTransaction();
            $id_user = uniqid('USR', $request->input('jurusan'));

            User::create([
                'id' => $id_user,
                'email' => $request->input('register-email'),
                'password' => bcrypt($request->input('password')),
            ]);

            Mahasiswa::create([
                'nim' => $request->input('register-nim'),
                'id' => $id_user,
                'name' => $request->input('register-name'),
                'prodi_id' => $request->input('register-prodi'),
                'jurusan_id' => $request->input('register-jurusan'),
            ]);

            DB::commit();

            return redirect()->route('authForm')->with('success', 'Registration successful. You can now log in.');
        } catch (\Exception $e) {
            DB::rollBack();
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
