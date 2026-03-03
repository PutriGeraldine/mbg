<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        $roles = Role::where('name', '!=', 'super-admin')->pluck('name');
        return view('auth.register', compact('roles'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'role' => 'required|exists:roles,name',
        ]);

        $requestedRole = $request->role;

        // user biasa langsung aktif
        $status = ($requestedRole === 'user') ? 'active' : 'pending';

        $user = User::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'password'       => Hash::make($request->password),
            'status'         => $status,
            'requested_role' => $requestedRole,
        ]);

        // kalau user biasa langsung assign
        if ($requestedRole === 'user') {
            $user->assignRole('user');
        }

        return redirect()->route('login')
            ->with('success',
                $status === 'pending'
                ? 'Register berhasil, menunggu approval'
                : 'Register berhasil, silakan login'
            );
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email','password');

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            if ($user->status !== 'active') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun Anda belum di-approve super-admin'
                ]);
            }

            if ($user->hasRole('super-admin')) return redirect()->route('superadmin.dashboard');
            if ($user->hasRole('admin'))       return redirect()->route('admin.dashboard');
            if ($user->hasRole('pemda'))       return redirect()->route('pemda.dashboard');
            if ($user->hasRole('user'))        return redirect()->route('user.dashboard');

            Auth::logout();
            return back()->withErrors(['email'=>'Role user tidak valid']);
        }

        return back()->withErrors(['email'=>'Email atau password salah']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function rolePermission()
    {
        $users = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'super-admin');
        })->get();

        return view('rolepermission', compact('users'));
    }

    public function pendingUsers()
    {
        $users = User::whereIn('requested_role',['admin','pemda'])
                    ->where('status','pending')
                    ->get();

        return view('auth.pending', compact('users'));
    }

    public function approveUser($id)
    {
        $user = User::findOrFail($id);

        $user->assignRole($user->requested_role);
        $user->update(['status'=>'active']);

        return back()->with('success','User berhasil di-approve');
    }

    public function rejectUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status'=>'rejected']);

        return back()->with('success','User ditolak');
    }
}