<?php

namespace App\Http\Controllers\Admin;

use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Config;

class PermissionsController extends Controller
{
    public function index()
    {
        $data['permissions'] = Permission::all();
        return view('admin.modules.permissions.permissions_list', $data);
    }

    public function create()
    {
        $data['modules'] = Config::get('modules.names');
        return view('admin.modules.permissions.permissions_form', $data);
    }

    public function edit($id)
    {
        $data['permission'] = Permission::find($id);
        $data['modules'] = Config::get('modules.names');
        return view('admin.modules.permissions.permissions_form', $data);
    }

    public function destroy($id)
    {
        $permission = Permission::find($id);
        $permission->delete();
        toastr()->success('Permission removed');
        return redirect()->route('admin:permissions');
    }

    public function store(Request $request)
    {
       $update_id = $request->id;

        if (isset($update_id) && !empty($update_id) && $update_id != 0) {
            $permissions_data = Permission::where('id', $update_id)->first();
            $permissions_data->update($request->all());
            notify()->success('Permission updated!');
            return redirect()->route('admin:permissions');
        }else{

            $validator = Validator::make($request->all(), [
                'name' => 'unique:permissions',
            ]);
            if ($validator->fails()) {
                notify()->error('Permission already exists!');
                return redirect()->route('admin:permissions');
            }

            $permission = new Permission();
            $permission->name = $request->name;
            $permission->module = $request->module;
            $permission->save();
            $last_id = $permission->id;
            if (isset($last_id) && !empty($last_id)) {
                notify()->success('Permission added successfully!');
                return redirect()->route('admin:permissions');
            }else
            {
                notify()->error('Something Went wrong!');
                return back();
            }
        }


    }
}
