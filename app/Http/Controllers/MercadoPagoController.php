<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;

class MercadoPagoController extends Controller
{
    public function __construct()
    {
        MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));
        MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL);
    }

    public function process(Request $request)
    {
        
    $cartItems = json_decode($request->input('cart_items'), true);

    $productIds = collect($cartItems)->pluck('product_id');
    $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

    $total = 0;

    foreach ($cartItems as $cartItem) {
        $product = $products->get($cartItem['product_id']);
        $quantidade = $cartItem['quantity'];

        if (! $product || $product->quantity < $quantidade) {
            return redirect()->route('erroDePagamento')->withErrors([
                'quantidade_produto' => 'Quantidade solicitada não disponível para o produto: ' . ($product->name ?? 'desconhecido'),
            ]);
        }

        $total += $product->price * $quantidade;
    }

    $externalReference = (string) Str::uuid();

    $order = DB::transaction(function () use ($request, $cartItems, $products, $total, $externalReference) {
        $order = Order::create([
            'buyer_id' => $request->user()->id,
            'total' => $total,
            'status' => 'paid',
            'reference_id' => $externalReference,
        ]);

        foreach ($cartItems as $cartItem) {
            $product = $products->get($cartItem['product_id']);
            $quantidade = $cartItem['quantity'];

            $product->decrement('quantity', $quantidade);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $quantidade,
                'unit_price' => $product->price,
                'sub_total' => $product->price * $quantidade,
                'seller_id' => $product->user_id,
            ]);
        }

        return $order;
    });

    $preferenceItems = $order->items->map(function ($item) {
        return [
            'title' => $item->product->name,
            'quantity' => $item->quantity,
            'currency_id' => 'BRL',
            'unit_price' => (float) $item->unit_price,
        ];
    })->toArray();

    $client = new PreferenceClient();

    try {
    $preference = $client->create([
        'items' => $preferenceItems,
        'payer' => [
            'name' => $request->user()->name,
            'email' => $request->user()->email,
        ],
        'back_urls' => [
            'success' => route('mercadopago.success'),
            'failure' => route('mercadopago.failure'),
            'pending' => route('mercadopago.pending'),
        ],
        'external_reference' => $externalReference,
        'notification_url' => route('mercadopago.webhook'),
    ]);
    } catch (\Throwable $e) {
        \Log::error('Erro ao criar preferência Mercado Pago', [
            'message' => $e->getMessage(),
            'order_id' => $order->id,
    ]);

        return redirect()->route('erroPagamento')->withErrors([
            'mercadopago' => 'Não foi possível iniciar o pagamento. Tente novamente.',
        ]);
    }

    // $order->update(['preference_id' => $preference->id]);

    return redirect($preference->init_point);
}

    public function webhook(Request $request)
    {
        $type = $request->query('type');
        $paymentId = $request->query('data_id') ?? $request->input('data.id');

        if ($type !== 'payment' || ! $paymentId) {
            return response()->json(['status' => 'ignored']);
        }

        $payment = (new PaymentClient())->get($paymentId);

        $order = Order::where('reference_id', $payment->external_reference)->first();

        if ($order) {
            $order->update(['status' => $payment->status]);
        }

        return response()->json(['status' => 'ok']);
    }
}