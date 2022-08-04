<?php

namespace App\Http\Controllers\Api\Client;

use App\Models\Addon;
use App\Models\Filter;
use App\Models\Country;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AmrShawky\LaravelCurrency\Facade\Currency;

class ProductsController extends Controller
{
    public function productsList(Request $request)
    {
        $setting = Setting::find(1);
        $toConversion = ($request->currency ? $request->currency : Country::DEFAULT_CURRENCY);
        $rates = $this->currencyRate(Country::DEFAULT_CURRENCY, $toConversion);
        // dd($rates);
        $search = $request->search;
        $products = Product::where('status', 1)
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'LIKE', '%' . $search . '%');
            })
            ->with('addons')
            ->orderBy('id', 'desc')
            ->paginate($request->limit ?? 5);
        $success['products'] = $products;
        if ($products->isEmpty()) {

            return $this->sendResponse($success, 'No products found!');
        }
        foreach ($products as $product) {
            if ($product->questions) {
                $questions = json_decode($product->questions);
                if ($questions) {
                    $temp = array();
                    foreach ($questions as $key => $question) {
                        $found = Question::select('id', 'question')->where('id', $question)->first();
                        $temp[] = $found;
                    }
                    $product->questions = $temp;
                }
            }
            if ($product->filters) {
                $filters = json_decode($product->filters);
                if ($filters) {
                    $temp2 = array();
                    foreach ($filters as $filter) {
                        $found = Filter::select('id', 'title')->where('id', $filter)->first();
                        $temp2[] = $found;
                    }
                    $product->filters = $temp2;
                }
            }
            if ($product->addons) {
                $addons = $product->addons;
                if ($addons) {
                    $temp3 = array();
                    foreach ($addons as $addon) {

                        $found = Addon::select('id', 'type', 'title', 'price')->where('id', $addon->addon_id)->first();
                        if($found){
                            $found->price = round(($found->price * $rates->$toConversion), 2);
                        }

                        $temp3[] = $found;
                    }
                    unset($product->addons);
                    $weight = array_filter($temp3, function ($item) {
                        if($item){
                            return $item["type"] === 'weight';
                        }
                    });
                    $size = array_filter($temp3, function ($item) {
                        if($item){
                            return $item["type"] === 'size';
                        }
                    });
                    $stone = array_filter($temp3, function ($item) {
                        if($item){
                            return $item["type"] === 'stone';
                        }
                    });
                    $engraving = array_filter($temp3, function ($item) {
                        if($item){
                            return $item["type"] === 'engraving';
                        }
                    });


                    $product->addons = [
                        'weight' => array_values((array)$weight),
                        'size' => array_values((array)$size),
                        'stone' => array_values((array)$stone),
                        'engraving' => array_values((array)$engraving)
                    ];
                }
            }
            if($product->gold_weight){
                $gold_price = $rates->XAU * 28.3495;
                $product->gold_price_per_gram = $gold_price;
                $gold_total_rate = ($product->gold_weight * $gold_price);
                $product->price = $product->price + $gold_total_rate;
            }
            $product->price =  round(($product->price * $rates->$toConversion), 2);
            if(isset($request->user()->shop_charges) && $request->user()->shop_charges === 1){
                if(isset($setting) && $setting->shop_charges > 0){
                    $percent = $setting->shop_charges;
                    $product->price *= (1 + $percent / 100);
                }
                
            }
            
        }
        $products->makeHidden(['status', 'created_at', 'updated_at']);
        return $this->sendResponse($success ?? [], 'Products found!.');
    }
}
