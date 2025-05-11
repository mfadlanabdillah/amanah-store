<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('orderProducts', 'paymentMethod')->get();

        $orders->transform(function ($order) {
            $order->payment_method = $order->paymentMethod->name ?? '-';
            $order->orderProducts->transform(function ($item) {
                return [
                    'product' => $item->product_id,
                    'product_name' => $item->product->name ?? '-',
                    'quantity' => $item->quantity ?? 0,
                    'unit_price' => $item->unit_price ?? 0,
                ];
            });
            return $order;
        });

        return response()->json([
            'success' => true,
            'data' => $orders,
            'message' => 'Orders retrieved successfully',
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'nullable|email',
            'gender' => 'nullable|string',
            'phone' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'total_price' => 'required|numeric',
            'note' => 'nullable|string',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        foreach ($request->items as $item) {
            $product = Product::find($item['product_id']);
            if (!$product || $product->stock < $item['quantity']) {
                return response()->json([
                    'success' => false,
                    'data' => null,
                    'message' => 'Stok produk kosong: ' . $product->name,
                ], 422);
            }
        }

        $order = Order::create($request->only([
            'name',
            'email',
            'gender',
            'phone',
            'date_of_birth',
            'total_price',
            'note',
            'payment_method_id',
            'paid_amount',
            'change_amount'
        ]));

        foreach ($request->items as $item) {
            $order->orderProducts()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
            ]);

        }

        return response()->json([
            'success' => true,
            'data' => $order,
            'message' => 'Order created successfully',
        ], 200);
    }

    public function show($id)
    {
        $order = Order::with('orderProducts', 'paymentMethod')->find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => 'Order not found',
            ], 404);
        }

        $order->payment_method = $order->paymentMethod->name ?? '-';
        $order->orderProducts->transform(function ($item) {
            return [
                'product' => $item->product_id,
                'product_name' => $item->product->name ?? '-',
                'quantity' => $item->quantity ?? 0,
                'unit_price' => $item->unit_price ?? 0,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $order,
            'message' => 'Order retrieved successfully',
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => 'Order not found',
            ], 404);
        }

        $order->update($request->only([
            'name',
            'email',
            'gender',
            'phone',
            'date_of_birth',
            'total_price',
            'note',
            'payment_method_id',
            'paid_amount',
            'change_amount'
        ]));

        return response()->json([
            'success' => true,
            'data' => $order,
            'message' => 'Order updated successfully',
        ], 200);
    }

    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => 'Order not found',
            ], 404);
        }

        $order->delete();

        return response()->json([
            'success' => true,
            'data' => null,
            'message' => 'Order deleted successfully',
        ], 200);
    }
}
