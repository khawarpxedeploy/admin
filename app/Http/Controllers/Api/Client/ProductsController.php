<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Question;

class ProductsController extends Controller
{
    public function productsList(Request $request){

        $products = Product::where('status', 1)->get();
        $success['products'] = $products;
        if($products->isEmpty()){
     
            return $this->sendResponse($success, 'No products found!');
        }
        foreach($products as $key => $product){
            if($product->questions){
                $questions = json_decode($product->questions);
                if($questions){
                    $temp = array();
                    foreach($questions as $key => $question){
                        $found = Question::select('id', 'question')->where('id', $question)->first();
                        $temp[] = $found;
                    }
                    $product->questions = $temp;
                }
            }
        }
        $products->makeHidden(['status','created_at','updated_at']);
        return $this->sendResponse($success ?? [], 'Products found!.');
    }
}
