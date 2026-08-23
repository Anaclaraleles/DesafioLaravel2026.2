<x-layouts.app active="vendas" title="Histórico de vendas">

    <div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-3xl font-bold text-[#4E6E6E]">Histórico de Vendas</h1>
                <p class="text-sm text-[#8FA6A3]">{{ $sales->total() }} vendas encontradas</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('sales.pdf') }}"
                class="inline-flex items-center gap-2 bg-[#4E6E6E] hover:bg-[#3a5555] text-white font-medium px-5 py-3 rounded-lg transition cursor-pointer">
                    <x-heroicon-o-arrow-down-tray class="w-5 h-5" />
                    Baixar PDF
                </a>

                @if (auth()->user()->role === 'admin')
                <a href="{{ route('sales.excel') }}"
                    class="inline-flex items-center gap-2 bg-[#4E6E6E]/10 hover:bg-[#4E6E6E]/20 text-[#4E6E6E] font-medium px-5 py-3 rounded-lg border-2 border-[#2E3B2F] transition cursor-pointer">
                    <x-heroicon-o-table-cells class="w-5 h-5" />
                    Baixar Excel
                </a>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="w-full overflow-x-auto md:overflow-x-visible">
                <table class="w-full min-w-[1000px] md:min-w-0">
                    <thead class="bg-[#4E6E6E]">
                        <tr>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Pedido</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Data</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Produtos</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Vendido por</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Total</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                    @forelse ($sales as $sale)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-center text-sm text-gray-500">#{{ $sale->order_id }}</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-500">
                                {{ $sale->order->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700">
                                {{ $sale->product->name}}
                                <span class="text-gray-400">x{{ $sale->quantity }}</span>
                            </td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700">
                                {{ $sale->seller->name ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-center text-sm font-semibold text-green-600">
                                R$ {{ number_format($sale->sub_total, 2, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $statusStyles = [
                                        'pending' => ['label' => 'Pendente', 'class' => 'bg-yellow-100 text-yellow-800'],
                                        'paid' => ['label' => 'Pago', 'class' => 'bg-green-100 text-green-800'],
                                        'in_analysis' => ['label' => 'Em análise', 'class' => 'bg-blue-100 text-blue-800'],
                                        'canceled' => ['label' => 'Cancelado', 'class' => 'bg-red-100 text-red-800'],
                                        'refunded' => ['label' => 'Reembolsado', 'class' => 'bg-gray-100 text-gray-800'],
                                    ];
                                    $status = $statusStyles[$sale->order->status] ?? ['label' => $sale->order->status, 'class' => 'bg-gray-100 text-gray-800'];
                                @endphp
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $status['class'] }}">
                                    {{ $status['label'] }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-400">
                                Você ainda não fez nenhuma venda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8 flex justify-center">
            {{ $sales->links() }}
        </div>

        @if (auth()->user()->role === 'admin')
            <div class="mt-8">
                {!! $chart->renderHtml() !!}
                {!! $chart->renderJs() !!}
            </div>
        @endif
    </div>
</x-layouts.app>