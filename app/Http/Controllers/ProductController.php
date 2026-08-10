<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
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
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('images', 'public');
        }

        $data['user_id'] = auth()->id();

        Product::query()->create($data);

        return to_route('products.manage')->with('message', 'Alterado com sucesso!');
    }
    
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

            if ($request->hasFile('photo')) {
                $data['photo'] = $request->file('photo')->store('images', 'public');
            }

        $data['user_id'] = auth()->id();

        $product->update($data);

        return to_route('products.manage')->with('message', 'Alterado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return to_route('products.manage')->with('message', 'Deletado com sucesso!');
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
    public function manage()
    {
        $isAdmin = auth()->user()->role === 'admin';

        $products = $isAdmin
            ? Product::paginate(5)
            : Product::where('user_id', auth()->id())->paginate(5);

        return view('products.manage-products', compact('products'));
    }
}
