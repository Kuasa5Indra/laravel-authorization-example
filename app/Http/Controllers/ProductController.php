<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'price' => 'required|integer'
        ]);
        // Menggunakan Policy
        if($request->user()->cannot('create', Product::class)){
            return response()->json(["message" => "Anda tidak memiliki akses"], 403);
        }
        $product = Product::create($request->all());
        return response()->json(["message" => "Sukses membuat produk", "data" => $product], 201);
        // Menggunakan Gate
        /* if(Gate::allows('admin-only')){
            // Hanya User dengan role admin yang dapat mengakses ini
            $product = Product::create($request->all());
            return response()->json(["message" => "Sukses membuat produk", "data" => $product], 201);
        } */
        /* if(Gate::denies('user-only')){
            // Hanya User dengan role selain user yang dapat mengakses ini
            $product = Product::create($request->all());
            return response()->json(["message" => "Sukses membuat produk", "data" => $product], 201);
        } */
        // return response()->json(["message" => "Anda tidak memiliki akses"], 403);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'price' => 'required|integer'
        ]);
        // Menggunakan Policy
        if($request->user()->cannot('update', Product::class)){
            return response()->json(["message" => "Anda tidak memiliki akses"], 403);
        }
        $product = Product::findOrFail($id);
        $product->update($request->all());
        return response()->json(["message" => "Produk sudah diubah", "data" => $product], 201);
        // Menggunakan Gate
        /* if(Gate::allows('admin-only')){
            $product = Product::findOrFail($id);
            $product->update($request->all());
            return response()->json(["message" => "Produk sudah diubah", "data" => $product], 201);
        }
        return response()->json(["message" => "Anda tidak memiliki akses"], 403); */
    }

    public function destroy(Request $request, $id)
    {
        // Menggunakan Policy
        if($request->user()->cannot('delete', Product::class)){
            return response()->json(["message" => "Anda tidak memiliki akses"], 403);
        }
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(["message" => "Produk sudah dihapus"], 201);
        // Menggunakan Gate
        /* if(Gate::allows('admin-only')){
            $product = Product::findOrFail($id);
            $product->delete();
            return response()->json(["message" => "Produk sudah dihapus"], 201);
        }
        return response()->json(["message" => "Anda tidak memiliki akses"], 403); */
    }
}
