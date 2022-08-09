<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('id', 'desc')
            ->with('customer')
            ->get();
        $statuses = [
            'pending',
            'accepted',
            'delivered',
            'cancelled'
        ];
        foreach ($orders as $order) {
            foreach ($order->items as $value) {
                unset($value->order_id);
                $value->product = Product::select('name', 'price', 'image', 'description')->where('id', $value->product_id)->first();
                unset($value->product_id);
            }
        }
        return view('admin.modules.orders.index', compact('orders', 'statuses'));
    }

    public function detail($id)
    {
        $order = Order::where('id', $id)
            ->with('customer', 'items.product')
            ->first();
            foreach ($order->items as $key => $value) {
                $order->items[$key]['product'] = Product::select('name', 'price', 'image', 'description')->where('id', $value->product_id)->first();
            }

            return view('admin.modules.orders.detail', compact('order'));
    }

    public function change_status(Request $request)
    {
        $status = false;
        $message = "Error in Changing Status";
        $id = $request->id;
        $status = $request->status;
        if (isset($id) && !empty($id)) {
            Order::where('id', $id)->update(['status' => $status]);
            $status = true;
            $message = "Status Changed";
            notify()->success('Status Changed!');
        }
        return response()->json(['status' => $status, 'message' => $message]);
    }
}
