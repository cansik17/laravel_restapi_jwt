<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Product as ProductResource;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get articles
        $products = Product::paginate(10);
        //dd($products);

        // Return collection of articles as a resource
        // return ArticleResource::collection($articles);
        return  response(['products' => ProductResource::collection($products), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'title' => 'required|max:255',
            'description' => 'required',
            'price' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'type' => 'Validation Error']);
        }

        $products = Product::create($data);

        return response(['product' => new ProductResource($products), 'message' => 'Created successfully'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $products = Product::findOrFail($id);

        // Return single article as a resource
        return response(['product' => new ProductResource($products), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $products = Product::findOrFail($id);
        //dd($articles);
        $products->update($request->all());

        return response(['product' => new ProductResource($products), 'message' => 'Updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $products = Product::findOrFail($id);

      

        if ($products->delete()) {
            return response(['product' => new ProductResource($products), 'message' => 'Deleted successfully'], 200);
        }
        // return response('silindi', 200)
        //     ->header('Content-Type', 'text/plain');
    }
}
