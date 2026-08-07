<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
     public function index()
    {
        $products = Product::paginate(5);

        return view('admin.inicio', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        Product::query()->create($request->validated());

        return $user->role === 'admin'
            ? to_route('admin.inicio')
            : to_route('user.inicio');
    }
}
