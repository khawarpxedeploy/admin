<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;

class DashboardController extends Controller
{
    public function index(){
        $customers = Customer::get()->count();
        return view('admin.modules.dashboard.dashboard', compact('customers'));
    }
}
