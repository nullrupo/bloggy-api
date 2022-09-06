<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ApI\BaseController as BaseController;
use Validator;
use App\Http\Resources\Product as ProductResource;

class ProductController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);
        $this->middleware('permission:product-create', ['only' => ['create','store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $product = Product::latest()->paginate(5);
        return view('product.index',compact('product'));
        return $this->sendResponse(ProductResource::collection($product), 'Products retrieved successfully.');
    }
 


    public function create()
    {
        return view('product.create');
    }

    public function store(Request $request, $validator)
    {
        $validator = request()->validate([
            'name'         => 'required',
            'detail'       => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        Product::create($request->all());

        return redirect()->route('product.index')
                         ->with('success','Entry created successfully.');
        return $this->sendResponse(new ProductResource($product), 'Product created successfully.');
    } 

    public function show(Product $product)
    {
        return view('product.show',compact('product'));
        return $this->sendResponse(new ProductResource($product), 'Product retrieved successfully.');
    }

    public function edit(Product $product)
    {
        return view('product.edit',compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validator = request()->validate([
            'name'         => 'required',
            'detail'       => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $product->update($request->all());

        return redirect()->route('product.index')
                         ->with('success','Entry updated successfully');
        return $this->sendResponse(new ProductResource($product), 'product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('product.index')
                         ->with('success','Entry deleted successfully');
        return $this->sendResponse([], 'product deleted successfully.');                 
    }
}
