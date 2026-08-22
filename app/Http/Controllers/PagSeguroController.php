<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PagSeguroController extends Controller
{
    public function createCheckout(Request $request)
    {
        $url = config('services.pagseguro.checkout_url');
        $token = config('services.pagseguro.token');

        $cartItems = json_decode($request->input('cart_items'), true);
        $productIds = collect($cartItems)->pluck('product_id');
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $items = [];

        foreach ($cartItems as $cartItem) {
            $product = $products->get($cartItem['product_id']);

            $items[] = [
                'name' => $product->name,
                'quantity' => $cartItem['quantity'],
                'unit_amount' => round($product->price * 100),
            ];
        }

        $referenceId = uniqid();

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ])->withoutVerifying()->post($url, [
            'reference_id' => $referenceId,
            'items' => $items,
        ]);

        if ($response->successful()) {

            $total = 0;

            foreach ($cartItems as $cartItem) {
                $product = $products->get($cartItem['product_id']);
                $quantidadeProduto = $cartItem['quantity'];

                if ($product->quantity < $quantidadeProduto) {
                    return redirect()->route('erroDePagamento')->withErrors([
                        'quantidade_produto' => 'Quantidade solicitada não disponível para o produto: ' . $product->name,
                    ]);
                }

                $total += $product->price * $quantidadeProduto;
            }

            $order = Order::create([
                'buyer_id' => $request->user()->id,
                'total' => $total,
                'status' => 'pending',
                'reference_id' => $referenceId,
            ]);

            foreach ($cartItems as $cartItem) {
                $product = $products->get($cartItem['product_id']);
                $quantidadeProduto = $cartItem['quantity'];

                // Atualiza estoque do produto
                $product->quantity -= $quantidadeProduto;
                $product->save();

                // Atualiza saldo de quem vendeu o produto
                $valorTotal = $product->price * $quantidadeProduto;
                $vendedor = $product->user;
                $vendedor->balance += $valorTotal;
                $vendedor->save();

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantidadeProduto,
                    'unit_price' => $product->price,
                    'sub_total' => $valorTotal,
                    'seller_id' => $product->user_id,
                ]);
            }

            $pay_link = data_get($response->json(), 'links.1.href');
            return redirect()->away($pay_link);
        }

        return redirect()->route('erroPagamento');
    }
}