<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class SalesController extends Controller
{
    public function index()
    {
        $isAdmin = auth()->user()->role === 'admin';
        $sales = OrderItem::query()->when(! $isAdmin, function ($query) {
            $query->where('seller_id', Auth::id());
        })
        ->with(['order.buyer', 'product'])
        ->latest()
        ->paginate(5);
 
        return view('historicoVendas', compact('sales'));
    }

    public function downloadPdf(): Response
    {
        $isAdmin = auth()->user()->role === 'admin';

        $orderItems = OrderItem::query()
            ->when(! $isAdmin, function ($query) {
                $query->where('seller_id', Auth::id());
            })
            ->with(['order.buyer', 'product', 'seller'])
            ->latest()
            ->get();

        $pdf = Pdf::loadView('pdf.sales', [
            'orderItems' => $orderItems,
            'user' => Auth::user(),
            'isAdmin' => $isAdmin,
        ]);

        return $pdf->download('historico-de-vendas.pdf');
    }
}
