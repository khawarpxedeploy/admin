<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(){
        $customers = Customer::get()->count();
        $orders = Order::get()->count();
        $pending = Order::where('status', 'pending')->get()->count();
        $accepted = Order::where('status', 'accepted')->get()->count();
        $cancelled = Order::where('status', 'cancelled')->get()->count();
        return view('admin.modules.dashboard.dashboard', compact('customers', 'orders', 'pending', 'accepted', 'cancelled'));
    }
}
