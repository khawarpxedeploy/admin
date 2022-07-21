<?php

namespace App\Http\Controllers\Api\Client;

use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrderItems;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function createOrder(Request $request)
    {

        $messages = array(
            'products.required' => __('Products array is required.'),
            'type.required' => __('Order Type is required.'),
            'type.in' => __('Type must be (pickup or delivery).'),
            'total.required' => __('Total price is required.'),
            'total.regex' => __('Total price value must be valid.'),
            'payment_method.required' => __('Payment Method is required.'),
            'payment_method.in' => __('Payment method must be (cash or card).')
        );
        $validator = Validator::make($request->all(), [
            'products' => 'required',
            'type' => 'required|in:pickup,delivery',
            'total' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'payment_method' => 'required|in:cash,card'
        ], $messages);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $orderID = strtoupper(Str::random(10));
        $order = [
            'order_id' => $orderID,
            'customer_id' => $request->user()->id,
            'type' => $request->type,
            'total' => floatval($request->total),
            'payment_method' => $request->payment_method,
            'status' => 'pending',
            'pickup_location' => $request->pickup_location,
            'delivery_location' => $request->delivery_location
        ];

        $check = Order::create($order);
        if ($check) {
            $this->storeOrderProducts($check->id, $request->products);
            $success['order_id'] = $check->order_id;
            return $this->sendResponse($success, 'Order placed successfully!.');
        }
    }

    protected function storeOrderProducts($orderID, $products)
    {

        $products = json_decode($products);
        if ($products) {
            foreach ($products as $product) {
                $data = [
                    'order_id' => $orderID,
                    'product_id' => $product->product_id,
                    'questions' => json_encode($product->questions),
                    'addons' => json_encode($product->addons),
                    'fonts' => $product->fonts,
                    'symbols' => $product->symbols,
                    'sub_total' => $product->sub_total,
                ];
                OrderItems::create($data);
            }
        }
        return true;
    }

    public function history(Request $request)
    {

        $orders = Order::where('customer_id', $request->user()->id)->orderBy('id', 'desc')
            ->with('customer', 'items')
            ->get();
        if (!$orders) {
            return $this->sendError('Not Found.', ['error' => 'No orders found. Place new order!']);
        }
        
        foreach($orders as $order){
            
            foreach($order->items as $value){
                unset($value->order_id);
                $value->product = Product::select('name', 'price', 'image', 'description')->where('id', $value->product_id)->first();
                unset($value->product_id);
                
                
            }
        }
        $success['orders'] = $orders;
        return $this->sendResponse($success, 'Orders history found!.');
    }
}
