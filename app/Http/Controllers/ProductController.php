<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;

use Illuminate\Support\Facades\App;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(Request $request)
    {
        if( trim($request->get('locale') ?? "") != "" && in_array($request->get('locale'), ['en', 'es', 'it', 'fr']) ) {
            $newLocale = $request->get('locale');
            App::setLocale($newLocale);
        }
    }

    public function index(Request $request, $category = NULL)
    {
        $products = Product::all();

        if(isset($category) && trim($category) != "") {
            //If they add a category to the URL, filter by category
            $products = $products->where('product_category','=',$category);
        }

        foreach($products as $product)
        {

            

        }

        return $products;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {

        $validated = $request->validated();

        return Product::create([
            'product_name' => $validated['name'],
            'product_desc' => $validated['description'],
            'product_category' => $validated['category'],
            'product_price' => $validated['price'],
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProductRequest $request, $id)
    {
        try {
            $product = Product::findOrFail($id);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            return response()->json([
                __('success') => __('false'),
                __('message') => __('404 not found'),
            ]);
        }

        $validated = $request->validated();

        $success = __('false');
        if($product->update([
            'product_name' => $validated['name'],
            'product_desc' => $validated['description'],
            'product_category' => $validated['category'],
            'product_price' => $validated['price'],
        ])) {
            $success = __('true');
        }

        return [
            __('success') => $success
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            return response()->json([
                __('success') => __('false'),
                __('message') => __('404 not found'),
            ]);
        }

        $success = __('false');
        if($product->delete()) {
            $success = __('true');
        }

        return [
            'success' => $success
        ];
    }
}
