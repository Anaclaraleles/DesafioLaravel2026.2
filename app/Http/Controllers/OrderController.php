<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('buyer_id', Auth::id())
            ->with('items.product')
            ->latest()
            ->paginate(5);
 
        return view('user.historicoCompras', compact('orders'));
    }

    public function downloadPdf(): Response
    {
         $orderItems = OrderItem::whereHas('order', function ($query) {
                $query->where('buyer_id', Auth::id());
            })
            ->with(['order.buyer', 'product', 'seller'])
            ->latest()
            ->get();
 
        $pdf = Pdf::loadView('pdf.orders', [
            'orderItems' => $orderItems,
            'user' => Auth::user(),
        ]);
 
        return $pdf->download('meu-historico-de-compras.pdf');
    }
}
