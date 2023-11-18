<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('name','asc')->paginate(100);
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::orderBy('name','asc')->get();
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        try {
            $role = Role::create([
                'name' => $request->name,
                'guard_name' => 'web'
            ]);
            $permissions = $request->except('_token', 'name');
            $role->givePermissionTo($permissions);
            session()->flash('success', 'Role granted');
            return redirect()->route('admin.roles.index');
        } catch (\Exception $ex) {
            session()->flash('error', $ex->getMessage());
            return redirect()->back();
        }
    }

    public function edit(Role $role)
    {
        $permissions = Permission::orderBy('name','asc')->get();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required',
        ]);

        try {
            $role->update([
                'name' => $request->name,
            ]);
            $permissions = $request->except('_token', 'name','_method');
            $role->syncPermissions($permissions);
            session()->flash('success','Role Updated Successfully');
            return redirect()->route('admin.roles.index');
        } catch (\Exception $ex) {
            session()->flash('error', $ex->getMessage());
            return redirect()->back();
        }
    }
    public function delete(Request $request)
    {
        $id = $request->id;
        try {
            $role = Role::find($id);
            $role->delete();
            session()->flash('success', __('Role deleted successfully.'));
            return response()->json([1]);
        } catch (\Exception $exception) {
            session()->flash('error', $exception->getMessage());
            return response()->json([0]);
        }
    }
}
