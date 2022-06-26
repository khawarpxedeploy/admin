<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('id', 'desc')
                    ->get();
        return view('admin.modules.roles.roles_list', compact('roles'));
    }

    public function create()
    {
        return view('admin.modules.roles.role_form');
    }

    public function edit($id)
    {
        $role = Role::find($id);
        return view('admin.modules.roles.role_form', compact('role'));
    }

    public function store(Request $request)
    {
        $update_id = $request->id;

        if (isset($update_id) && !empty($update_id) && $update_id != 0) {
            $roles_data = Role::where('id', $update_id)->first();
            $roles_data->update($request->all());
            notify()->success('Role updated successfully!');
            return redirect()->route('admin:roles');
        } else {
            $role = Role::create(['name' => $request->name]);
            $last_id = $role->id;
            if (isset($last_id) && !empty($last_id)) {
                notify()->success('Role added successfully!');
                return redirect()->route('admin:roles');
            } else {
                notify()->error('Something Went wrong!');
                return back();
            }
        }
    }

    public function permission_modules_update(Request $request)
    {
        $modules = $request->modules;
        $role_id = $request->id;
        if (isset($modules) && isset($role_id) && !empty($modules) && !empty($role_id)) {
            $all_permissions = array();
            foreach ($modules as $value) {
                $permission = Permission::where('name', $value)->get();
                $all_permissions[] = $permission;
            }

            if(isset($all_permissions) && !empty($all_permissions))
            {
                $role = Role::where('id', $role_id)->first();
                $role->syncPermissions($all_permissions);
            }
            notify()->success('Permissions Updated for '.$role->name.'!');
            return redirect()->route('admin:roles');
        } else {
            return back()->with('error', 'Something Went wrong!');
        }
    }

    public function permission_modules(Request $request)
    {
        $role_id = $request->id;
        $modules = DB::table('permissions')
                ->select('module')
                ->groupBy('module')
                ->orderBy('id')
                ->get();
        $modules = json_decode($modules, true);
        if (isset($modules) && !empty($modules)) {
            foreach ($modules as $key => $value) {
                $permissions = DB::table('permissions')
                ->select('name', 'id')
                ->where('module', $value)
                ->orderBy('id')
                ->get();
                $modules[$key]['permissions'] = $permissions;
            }
        }
        $data['permissions_list'] = $modules;
        $roles = Role::where('id', $role_id)->first();
        $permissions = $roles->getAllPermissions();
        $active_permissions = array();
        foreach($permissions as $value)
        {
            $active_per_id = json_decode($value->id);
            $active_permissions[] = $active_per_id;

        }
        $data['permissions_active'] = $active_permissions;
        $data['role_id'] = $role_id;
        return view('admin.modules.roles.permission_modules', $data);
    }

    public function destroy($id)
    {
        $role = Role::find($id);
        $role->delete();
        notify()->success('Role deleted successfully!');
        return back();
    }


    public function change_status(Request $request)
    {
        $status = false;
        $message = "Error in Changing Status";
        $id = $request->id;
        $status = $request->status;
        if (isset($id) && !empty($id)) {
            if ($status == 0) {
                $status = 1;
            } else {
                $status = 0;
            }
            $change = Role::where('id', $id)->update(['status' => $status]);
            $status = true;
            $message = "Status Changed";
        }
        return response()->json(['status' => $status, 'message' => $message]);
    }
}
