<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\RoleRequest;

class RolePermissionController extends Controller
{
    // hanya super-admin bisa akses
    public function __construct()
    {
        $this->middleware(['auth','role:super-admin']);
    }

    // tampilkan semua role & permission
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();

        // ambil role request pending (misal)
        $roleRequests = RoleRequest::with('user')->get();

        return view('rolepermission', compact('roles','permissions','roleRequests'));
    }

    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name'
        ]);

        Role::create(['name' => $request->name]);
        return redirect()->back()->with('success','Role berhasil dibuat');
    }

    public function storePermission(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name'
        ]);

        Permission::create(['name' => $request->name]);
        return redirect()->back()->with('success','Permission berhasil dibuat');
    }

    public function assignPermission(Request $request)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
            'permission' => 'required|exists:permissions,name',
        ]);

        $role = Role::findByName($request->role);
        $role->givePermissionTo($request->permission);

        return redirect()->back()->with('success','Permission berhasil diberikan ke role');
    }
}