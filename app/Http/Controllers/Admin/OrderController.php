<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::orderBy('id', 'desc')
        ->with('customer')
        ->get();
        $statuses = [
            'pending',
            'accepted',
            'delivered',
            'cancelled'
        ];
        foreach($orders as $order){
            foreach($order->items as $value){
                unset($value->order_id);
                $value->product = Product::select('name', 'price', 'image', 'description')->where('id', $value->product_id)->first();
                unset($value->product_id);
            }
        }
        return view('admin.modules.orders.index', compact('orders', 'statuses'));
    }
}
