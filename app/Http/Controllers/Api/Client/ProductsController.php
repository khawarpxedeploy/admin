<?php

namespace App\Http\Controllers\Api\Client;

use App\Models\Addon;
use App\Models\Filter;
use App\Models\Country;
use App\Models\Product;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AmrShawky\LaravelCurrency\Facade\Currency;

class ProductsController extends Controller
{
    public function productsList(Request $request)
    {
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

                        $temp3[] = $found;
                    }
                    unset($product->addons);
                    if ($temp3) {
                        $weight = array_filter($temp3, function ($item) {
                            return $item["type"] === 'weight';
                        });
                        $size = array_filter($temp3, function ($item) {
                            return $item["type"] === 'size';
                        });
                        $stone = array_filter($temp3, function ($item) {
                            return $item["type"] === 'stone';
                        });
                        $engraving = array_filter($temp3, function ($item) {
                            return $item["type"] === 'engraving';
                        });
                    }


                    $product->addons = [
                        'weight' => array_values((array)$weight) ?? null,
                        'size' => array_values((array)$size) ?? null,
                        'stone' => array_values((array)$stone) ?? null,
                        'engraving' => array_values((array)$engraving) ?? null
                    ];
                }
            }
            $toConversion = ($request->currency ? $request->currency : Country::DEFAULT_CURRENCY);
            $product->price = Currency::convert()
                ->from(Country::DEFAULT_CURRENCY)
                ->to($toConversion)
                ->amount($product->price)
                ->date(date('Y-m-d'))
                ->round(2)
                ->get();
        }
        $products->makeHidden(['status', 'created_at', 'updated_at']);
        return $this->sendResponse($success ?? [], 'Products found!.');
    }
}
