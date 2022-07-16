<?php

namespace App\Http\Controllers\Api\Client;

use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function createOrder(Request $request){

        $messages = array(
            'product_id.required' => __('Product ID is required.'),
            'product_id.integer' => __('Product ID must be integer value.'),
            'product_id.exists' => __('Product ID not exists in system.'),
            'type.required' => __('Order Type is required.'),
            'type.in' => __('Type must be (pickup or delivery).'),
            'price.required' => __('Price is required.'),
            'price.regex' => __('Price value must be valid.'),
            'payment_method.required' => __('Payment Method is required.'),
            'payment_method.in' => __('Payment method must be (cash or card).')
        );
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer|exists:products,id',
            'type' => 'required|in:pickup,delivery',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'payment_method' => 'required|in:cash,card'
        ], $messages);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $orderID = strtoupper(Str::random(10));
        $order = [
            'order_id' => $orderID,
            'customer_id' => $request->user()->id,
            'product_id' => intval($request->product_id),
            'type' => $request->type,
            'price' => floatval($request->price),
            'payment_method' => $request->payment_method,
            'questions' => $request->questions,
            'addons' => $request->addons,
            'fonts' => $request->fonts,
            'symbols' => $request->symbols,
            'status' => 'pending',
            'pickup_location' => $request->pickup_location,
            'delivery_location' => $request->delivery_location
        ];

        $check = Order::create($order);
        if($check){
            $success['order_id'] = $check->order_id;
            return $this->sendResponse($success, 'Order placed successfully!.');
        }
    }

    public function history(Request $request){

        $orders = Order::where('customer_id', $request->user()->id)->orderBy('id', 'desc')
        ->with('customer', 'product')
        ->get();
        if(!$orders){
            return $this->sendError('Not Found.', ['error' => 'No orders found. Place new order!']);
        }
        $success['orders'] = $orders;
        return $this->sendResponse($success, 'Orders history found!.');
    }
}
