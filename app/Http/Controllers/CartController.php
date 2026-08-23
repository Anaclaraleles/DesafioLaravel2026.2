<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCartItemRequest;
use App\Http\Requests\UpdateCartItemRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Exibe o carrinho do usuário logado.
     */
    public function index(): View
    {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        return view('user.cart', compact('cart'));
    }

    /**
     * Adiciona um produto ao carrinho.
     */
    public function store(StoreCartItemRequest $request)
    {
        $data = $request->validated();

        $product = Product::find($data['product_id']);
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        $item = $cart->items()->where('product_id', $product->id)->first();
        $newQuantity = $item ? $item->quantity + $data['quantity'] : $data['quantity'];

        if ($newQuantity > $product->quantity) {
            return back()->withErrors([
                'quantity' => "Estoque insuficiente. Disponível: {$product->quantity}.",
            ]);
        }

        if ($item) {
            $item->update([
                'quantity' => $newQuantity,
                'unit_price' => $product->price,
            ]);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $data['quantity'],
                'unit_price' => $product->price,
            ]);
        }

        return redirect()
            ->route('cart.index')
            ->with('success', 'Produto adicionado ao carrinho.');
    }

    public function update(UpdateCartItemRequest $request, CartItem $cartItem)
    {
        $data = $request->validated();

        if ($data['quantity'] > $cartItem->product->quantity) {
            return back()->withErrors([
                'quantity' => "Estoque insuficiente. Disponível: {$cartItem->product->quantity}.",
            ]);
        }

        $cartItem->update([
            'quantity' => $data['quantity'],
            'unit_price' => $cartItem->product->price,
        ]);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Quantidade atualizada.');
    }

    public function destroy(CartItem $cartItem)
    {
        $cartItem->delete();

        return redirect()
            ->route('cart.index')
            ->with('success', 'Item removido do carrinho.');
    }

    public function clear()
    {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        $cart->clearItems();

        return redirect()
            ->route('cart.index')
            ->with('success', 'Carrinho esvaziado.');
    }
}