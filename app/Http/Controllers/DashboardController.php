<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->hasRole('super-admin')) {
            return view('dashboard.superadmin');
        }

        if ($user->hasRole('admin')) {
            return view('dashboard.admin');
        }

        if ($user->hasRole('pemda')) {
            return view('dashboard.pemda');
        }

        return view('dashboard.user');
    }
}