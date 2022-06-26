<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Auth;
use Validator;

class AuthController extends Controller
{

    function register(Request $request)
    {
        $messages = array(
            'name.required' => __('Name field is required.'),
            'name.string' => __('Name must be string.'),
            'email.required' => __('Email field is required.'),
            'email.string' => __('Email must be string.'),
            'email.email' => __('Email address must be valid.'),
            'email.unique' => __('Email address is already taken.'),
            'password.required' => __('Password field is required.'),
            'password.string' => __('Password must be string.'),
            'password.min' => __('Password must be at-least 8 characters.')
        );
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:customers',
            'password' => 'required|string|min:8'
        ], $messages);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $user = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $success['token'] =  $user->createToken('auth_token')->plainTextToken;
   
        return $this->sendResponse($success, 'User registered successfully.');
    }

    function login(Request $request)
    {
        $messages = array(
            'email.required' => __('Email field is required.'),
            'email.email' => __('Email address must be valid.'),
            'password.required' => __('Password field is required.')
        );
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ], $messages);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $user = Customer::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password) && $user->status == 1) {
                $token = $user->createToken('MyApp')->plainTextToken;
                $success['token'] = $token;
                $user->makeHidden(['id','created_at','updated_at']);
                $success['user'] = $user;
                return $this->sendResponse($success, 'User login successfully.');
            } else {
                return $this->sendError('Unauthorised.', ['error'=>'Invalid credentials!']);
            }
        } else {
            return $this->sendError('Unauthorised.', ['error'=>'User does not exist']);
        }
    }

    function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        $success = [];
        return $this->sendResponse($success, 'User logged out successfully.');
    }

    function profileUpdate(Request $request){


        $messages = array(
            'image.image' => __('Image field must be image file type.'),
            'image.mimes' => __('Supported extensions for image are jpeg,png,jpg only.'),
            'image.max' => __('Image size should be less than 2MB.')
        );
        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], $messages);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        } 

        try {

            $user = $request->user();
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->address = $request->address;
            if($request->hasFile('image')){
                $user->image = $request->image->store('users','public');
            }
            $user->save();
            $user->makeHidden(['id','created_at','updated_at']);
            if($user->image){
                $user->image = Storage::url($user->image);
            }
            $success['user'] = $user;
            return $this->sendResponse($success, 'User login successfully.');

        } catch(Exception $e){
            return $this->sendError('Server Error.', ['error'=> $e->getMessage()]);
        }

    }

    public function customers(Request $request){

        $customers = Customer::orderBy('id', 'desc')->get();
        return view('admin.modules.customers.index', compact('customers'));
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
            $change = Customer::where('id', $id)->update(['status' => $status]);
            $status = true;
            $message = "Status Changed";
            notify()->success('Status Changed!');
        }
        return response()->json(['status' => $status, 'message' => $message]);
    }

    // function store_token(Request $request){

    //     $messages = array(
    //         'token.required' => __('Token field is required.')
    //     );
    //     $validator = Validator::make($request->all(), [
    //         'token' => 'required'
    //     ], $messages);

    //     if ($validator->fails()) {
    //         return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
    //     }

    //     $customer = $request->user();

    //     $token = array();
    //     $token['customer_id'] = $customer->id;
    //     $token['token'] = $request->token;
    //     CustomerToken::create($token);

    //     return response()->json(['status' => true, 'message' => "Device token has been stored!"]);

    // }
}
