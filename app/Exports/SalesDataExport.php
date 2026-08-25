<?php

namespace App\Exports;

use App\Models\OrderItem;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SalesDataExport implements FromView, ShouldAutoSize
{
    use Exportable;

    private $sales;

    public function __construct()
    {
        $isAdmin = Auth::user()->role === 'admin';

        $this->sales = OrderItem::query()
            ->when(! $isAdmin, function ($query) {
                $query->where('seller_id', Auth::id());
            })
            ->with([
                'order.buyer' => fn ($q) => $q->withTrashed(),
                'product' => fn ($q) => $q->withTrashed(),
                'seller' => fn ($q) => $q->withTrashed(),
            ])
            ->latest()
            ->get();
    }

    public function view(): View
    {
        return view('excel.sales', [
            'sales' => $this->sales,
        ]);
    }
}