<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Product extends Controller
{
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

        return to_route('inicio');
    }
}
