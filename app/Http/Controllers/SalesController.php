<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use App\Exports\SalesDataExport;
use Maatwebsite\Excel\Facades\Excel;

class SalesController extends Controller
{
    public function index()
    {
        $isAdmin = auth()->user()->role === 'admin';
        $sales = OrderItem::query()->when(! $isAdmin, function ($query) {
            $query->where('seller_id', Auth::id());
        })
        ->with([
            'order.buyer' => fn ($q) => $q->withTrashed(),
            'product' => fn ($q) => $q->withTrashed(),
            'seller' => fn ($q) => $q->withTrashed(),
        ])
        ->latest()
        ->paginate(5);

        //grafico de vendas por mes
        $chart_options = [
            'chart_title' => 'Quantidade de Vendas Realizadas por Mês',
            'model'       => Order::class,
            'chart_type'  => 'line',
            'report_type' => 'group_by_date',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'chart_color' => '82,186,86',
            'date_format' => 'm/Y',
        ];
 
        $chart = new LaravelChart($chart_options);
 
        return view('historicoVendas', compact('sales', 'chart'));
    }

    public function downloadPdf()
    {
        $isAdmin = auth()->user()->role === 'admin';

        $orderItems = OrderItem::query()
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

        $pdf = Pdf::loadView('pdf.sales', [
            'orderItems' => $orderItems,
            'user' => Auth::user(),
            'isAdmin' => $isAdmin,
        ]);

        return $pdf->download('historico-de-vendas.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new SalesDataExport(), 'historico-de-vendas.xlsx');
    }
}
