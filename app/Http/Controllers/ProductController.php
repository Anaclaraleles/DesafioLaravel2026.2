<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
     public function index()
    {
        $products = Product::paginate(6);

        $view = auth()->user()->role === 'admin' ? 'admin.inicio' : 'inicio';

        return view($view, compact('products'));
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

    public function search(Request $request)
    {
        $filters = $request->except('_token');

        $products = Product::where('name', 'LIKE', "%{$request->search}%")
            ->orWhere('category', 'LIKE', "%{$request->search}%")
            ->paginate(6);

        $view = auth()->user()->role === 'admin' ? 'admin.inicio' : 'inicio';

        return view($view, compact('products', 'filters'));
    }
}
