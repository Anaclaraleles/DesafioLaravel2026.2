<x-layouts.app active="compras" title="Minhas compras">

    <div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-3xl font-bold text-[#4E6E6E]">Minhas Compras</h1>
                <p class="text-sm text-[#8FA6A3]">{{ $orders->total() }} compras encontradas</p>
            </div>

            <a href="{{ route('orders.pdf') }}"
            class="inline-flex items-center gap-2 bg-[#52BA56] hover:bg-[#3a5555] text-white font-medium px-5 py-3 rounded-lg transition cursor-pointer">
                <x-heroicon-o-arrow-down-tray class="w-5 h-5" />
                Baixar PDF
            </a>
        </div>

        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="w-full overflow-x-auto md:overflow-x-visible">
                <table class="w-full min-w-[1000px] md:min-w-0">
                    <thead class="bg-[#4E6E6E]">
                        <tr>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Pedido</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Data</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Produtos</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Total</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($orders as $order)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-center text-sm text-gray-500">#{{ $order->id }}</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-500">
                                    {{ $order->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 text-center text-sm text-gray-700">
                                    <ul class="space-y-1">
                                        @foreach ($order->items as $item)
                                            <li>
                                                {{ $item->product->name }}
                                                <span class="text-gray-400">x{{ $item->quantity }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="px-6 py-4 text-center text-sm font-semibold text-green-600">
                                    R$ {{ number_format($order->total, 2, ',', '.') }}
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
                                        $status = $statusStyles[$order->status] ?? ['label' => $order->status, 'class' => 'bg-gray-100 text-gray-800'];
                                    @endphp
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $status['class'] }}">
                                        {{ $status['label'] }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-400">
                                    Você ainda não fez nenhuma compra.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8 flex justify-center">
            {{ $orders->links() }}
        </div>
    </div>
</x-layouts.app>