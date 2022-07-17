<?php

namespace App\Http\Controllers\Admin;

use App\Models\Addon;
use App\Models\Filter;
use App\Models\Product;
use App\Models\Question;
use App\Models\ProductAddon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('id', 'desc')
            ->get();
        return view('admin.modules.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $questions = Question::where('status', 1)->get();
        $filters = Filter::where('status', 1)->get();
        $sizes = Addon::where('type', Addon::SIZE)->get(['id', 'title']);
        $stones = Addon::where('type', Addon::STONE)->get(['id', 'title']);
        $weights = Addon::where('type', Addon::WEIGHT)->get(['id', 'title']);
        $engravings = Addon::where('type', Addon::ENGRAVING)->get(['id', 'title']);

        return view('admin.modules.products.form', compact('questions', 'filters', 'sizes', 'stones', 'weights', 'engravings'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $update_id = $request->id;
        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'fonts_enabled' => ($request->fonts_enabled ? 1 : 0),
            'symbols_enabled' => ($request->symbols_enabled ? 1 : 0),
            'description' => $request->description,
            'questions' => json_encode($request->questions),
            'filters' => json_encode($request->filters)
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->image->store('products', 'public');
        }

        if (isset($update_id) && !empty($update_id) && $update_id != 0) {
            $product = Product::where('id', $update_id)->first();
            $product->update($data);
            ProductAddon::where('product_id', $update_id)->delete();
            $sizes = $request->sizes;
            if ($sizes) {
                $this->storeAddons($update_id, $sizes);
            }
            $stones = $request->stones;
            if ($stones) {
                $this->storeAddons($update_id, $stones);
            }
            $weights = $request->weights;
            if ($weights) {
                $this->storeAddons($update_id, $weights);
            }
            $engravings = $request->engravings;
            if ($engravings) {
                $this->storeAddons($update_id, $engravings);
            }
            notify()->success('Product updated successfully!');
            return redirect()->route('admin:products');
        } else {
            $product = Product::create($data);
            $last_id = $product->id;
            $sizes = $request->sizes;
            if ($sizes) {
                $this->storeAddons($last_id, $sizes);
            }
            $stones = $request->stones;
            if ($stones) {
                $this->storeAddons($last_id, $stones);
            }
            $weights = $request->weights;
            if ($weights) {
                $this->storeAddons($last_id, $weights);
            }
            $engravings = $request->engravings;
            if ($engravings) {
                $this->storeAddons($last_id, $engravings);
            }
            if (isset($last_id) && !empty($last_id)) {
                notify()->success('Product added successfully!');
                return redirect()->route('admin:products');
            } else {
                notify()->error('Something Went wrong!');
                return back();
            }
        }
    }

    protected function storeAddons($product_id, $addons)
    {
        foreach ($addons as $value) {
            $data = [
                'product_id' => $product_id,
                'addon_id' => $value
            ];
            ProductAddon::create($data);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::where('id', $id)->with('addons')->first();
        // dd($product);
        $questions = Question::where('status', 1)->get();
        $filters = Filter::where('status', 1)->get();
        $sizes = Addon::where('type', Addon::SIZE)->get(['id', 'title']);
        $stones = Addon::where('type', Addon::STONE)->get(['id', 'title']);
        $weights = Addon::where('type', Addon::WEIGHT)->get(['id', 'title']);
        $engravings = Addon::where('type', Addon::ENGRAVING)->get(['id', 'title']);
        return view('admin.modules.products.form', compact('product', 'questions', 'filters','sizes', 'stones', 'weights', 'engravings'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        notify()->success('Product deleted successfully!');
        return back();
    }

    public function change_status(Request $request)
    {
        $status = false;
        $message = "Error in Changing Status";
        $id = $request->id;
        $status = $request->status;
        if (isset($id) && !empty($id)) {
            if ($status == 0) {
                $status = 1;
            } else {
                $status = 0;
            }
            $change = Product::where('id', $id)->update(['status' => $status]);
            $status = true;
            $message = "Status Changed";
            notify()->success('Status Changed!');
        }
        return response()->json(['status' => $status, 'message' => $message]);
    }
}
