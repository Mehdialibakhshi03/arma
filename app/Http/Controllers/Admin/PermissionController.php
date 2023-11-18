<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PermissionsDataTable;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    function __construct()
    {

    }

    public function index()
    {
        $permissions = Permission::orderby('name', 'asc')->paginate(50);
        return view('admin.permission.index',compact('permissions'));
    }

    public function create()
    {
        return view('admin.permission.create');
    }

    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required|unique:permissions,name,',
        ]);
        Permission::create($request->all());
        return redirect()->route('admin.permission.index')
            ->with('success',  __('Permission created successfully.'));
    }

    public function edit($id)
    {
        $permission = Permission::find($id);
        return view('admin.permission.edit', compact('permission'));
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::find($id);
        request()->validate([
            'name' => 'required|unique:permissions,name,'.$permission->id,
        ]);
        $permission->update($request->except('_token'));
        return redirect()->route('admin.permission.index')
            ->with('success',  __('Permission updated successfully.'));
    }

    public function delete(Request $request){
        try {
            DB::table("role_has_permissions")->where('permission_id', $request->id)->delete();
            $permission = Permission::find($request->id);
            $permission->delete();
            session()->flash('success','Permission deleted successfully');
            return response()->json([1]);
        }catch (\Exception $exception){
            session()->flash('error', $exception->getMessage());
            return response()->json([0]);
        }
    }
}
