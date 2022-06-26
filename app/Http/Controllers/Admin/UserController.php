<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use DB;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.modules.users.users_list', compact('users'));
    }

    public function create()
    {

        $roles = Role::all();
        return view('admin.modules.users.user_form', compact('roles'));
    }

    public function edit($id)
    {
        $user_data = User::find($id);
        $role = DB::table('model_has_roles')
            ->select('role_id')
            ->where('model_id', $user_data->id)
            ->first();
        $role_id = $role->role_id ?? '';
        $roles = Role::all();
        return view('admin.modules.users.user_form', compact('user_data', 'roles', 'role_id'));
    }


    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users|max:20|min:6',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:6|max:30',
            'role_id' => 'required|exists:roles,id'
        ]);

        $userData = $this->formFields($request);
        $user = User::create($userData);
        if ($user) {
            $this->assignRoleToUser($user->id, $request->role_id);
            notify()->success('User added successfully!');
            return redirect()->route('admin:users');
        } else {
            notify()->error('Something Went wrong!');
            return back()->with('error', 'Something Went wrong!');
        }
    }

    function update(Request $request)
    {

        $update_id = $request->id;
        if (isset($update_id) && !empty($update_id) && $update_id != 0) {
            $userData = $this->formFields($request);
            $user = User::where('id', $update_id)->update($userData);
            $this->assignRoleToUser($user, $request->role_id);
            notify()->success('User updated successfully!');
            return redirect()->route('admin:users');
        } else {
            notify()->error('Something Went wrong!');
            return back()->with('error', 'Something Went wrong!');
        }
    }

    function assignRoleToUser($user_id, $role_id)
    {

        $user = User::find($user_id);
        if ($user) {
            $role = Role::find($role_id);
            $user->syncRoles($role);
            $user->save();
        }
    }

    function formFields($request)
    {

        $postData = array();
        $postData['name'] = $request->name;
        $postData['username'] = $request->username;
        $postData['email'] = $request->email;
        if (isset($request->password) && !empty($request->password)) {
            $postData['password'] = Hash::make($request->password);
        }
        $postData['phone'] = $request->phone;
        $postData['address'] = $request->address;
        $postData['gender'] = $request->gender;
        $postData['country'] = $request->country;
        $postData['city'] = $request->city;
        $postData['status'] = 1;
        return $postData;
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        notify()->success('User deleted successfully!');
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
            $change = User::where('id', $id)->update(['status' => $status]);
            $status = true;
            $message = "Status Changed";
        }
        return response()->json(['status' => $status, 'message' => $message]);
    }
}
