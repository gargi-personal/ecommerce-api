<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Traits\ApiResponse;

class ProductController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $products = Product::with('user')->paginate(10);

        return $this->successResponse(
            ProductResource::collection($products),
            'Products fetched successfully',
            [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'total' => $products->total()
            ]
        );
    }

    public function show($id)
    {
        $product = Product::with('user')->find($id);
        if (!$product) {
            return $this->errorResponse('Product not found', 404);
        }

        return $this->successResponse(
            new ProductResource($product),
            'Product fetched successfully'
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'is_active' => 'required|boolean',
        ]);

        $product = Product::create(array_merge($request->all(), [
            'user_id' => $request->user()->id
        ]));

        return $this->successResponse(
            new ProductResource($product),
            'Product created successfully',
            [],
            201
        );
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return $this->errorResponse('Product not found', 404);
        }

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric',
            'stock' => 'sometimes|required|integer',
            'is_active' => 'sometimes|required|boolean',
        ]);

        $product->update($request->all());

        return $this->successResponse(
            new ProductResource($product),
            'Product updated successfully'
        );
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return $this->errorResponse('Product not found', 404);
        }

        $product->delete();

        return $this->successResponse(
            null,
            'Product deleted successfully'
        );
    }
}