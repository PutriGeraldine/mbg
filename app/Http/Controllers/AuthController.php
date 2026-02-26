<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        $roles = Role::whereNotIn('name', ['super-admin', 'user'])->get();
        return view('auth.register', compact('roles'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'role' => 'nullable|exists:roles,name'
        ]);

        $status = ($request->role == 'user' || !$request->role) ? 'active' : 'pending';

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $status
        ]);

        if ($request->role && $request->role != 'user') {
            $user->assignRole($request->role);
        } else {
            $user->assignRole('user');
        }

        return redirect()->route('login')->with('success', 'Register berhasil, '.($status=='pending'?'menunggu approval':'silakan login'));
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->status != 'active') {
                Auth::logout();
                return redirect()->back()->withErrors(['email'=>'Akun Anda belum di-approve super-admin']);
            }

            return redirect()->route('dashboard');
        }

        return redirect()->back()->withErrors(['email'=>'Email atau password salah']);
    }

    public function dashboard()
    {
        $user = Auth::user();
        $roles = Auth::user()->roles->pluck('name')->implode(', ');
        return view('auth.dashboard', compact('user', 'roles'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    // Super Admin
    public function pendingUsers()
    {
        $users = User::role(['admin','pemda'])->where('status','pending')->get();
        return view('auth.pending', compact('users'));
    }

    public function approveUser($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'active';
        $user->save();

        return redirect()->back()->with('success','User berhasil di-approve');
    }
}