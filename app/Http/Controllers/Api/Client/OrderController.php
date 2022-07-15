<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

    }
}
