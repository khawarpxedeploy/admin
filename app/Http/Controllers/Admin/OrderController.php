<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::orderBy('id', 'desc')
        ->with('customer', 'product')
        ->get();
        $statuses = [
            'pending',
            'accepted',
            'delivered',
            'cancelled'
        ];
        return view('admin.modules.orders.index', compact('orders', 'statuses'));
    }
}
