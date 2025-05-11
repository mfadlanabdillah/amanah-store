<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Get All Product
     */
    public function index()
    {
        $products = Product::all();

        return response()->json([
            'success' => true,
            'data' => $products,
            'message' => 'Products retrieved successfully',
        ], 200);
    }

    /**
     * Store New Product
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Get Product By ID
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update Product By ID
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove Product By ID
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Get Product By Barcode
     */
    public function showByBarcode(string $barcode)
    {
        $product = Product::where('barcode', $barcode)->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => 'Product not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $product,
            'message' => 'Product retrieved successfully',
        ], 200);
    }
}
