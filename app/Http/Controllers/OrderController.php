<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->get();
        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required|exists:products,id', 
            'amount' => 'required|integer',
        ]);

        $product = Product::find($request->product_id);
        $order = Order::create([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'total_price' => $request->amount * $product->price
        ]);

        return response()->json(["message" => "Order berhasil dibuat", "data" => $order], 201);
    }

    public function show(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        // Menggunakan Policy
        if($request->user()->cannot('view', $order)){
            return response()->json(["message" => "Anda tidak memiliki akses"], 403);
        }
        return response()->json($order);
        // Menggunakan Gate
        /* if(Gate::allows('view-order', $order)){
            return response()->json($order);
        }
        return response()->json(["message" => "Anda tidak memiliki akses"], 403); */
    }
}
