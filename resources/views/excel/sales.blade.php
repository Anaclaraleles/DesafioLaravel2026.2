<table>
    <thead>
        <tr>
            <th>Pedido</th>
            <th>Data</th>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Categoria</th>
            <th>Valor</th>
            <th>Comprado por</th>
            <th>Vendido por</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($sales as $sale)
            <tr>
                <td>{{ $sale->order_id }}</td>
                <td>{{ $sale->order->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $sale->product->name }}</td>
                <td>{{ $sale->quantity }}</td>
                <td>{{ $sale->product->category ?? '—' }}</td>
                <td>{{ number_format($sale->sub_total, 2, ',', '.') }}</td>
                <td>{{ $sale->order->buyer->name ?? '—' }}</td>
                <td>{{ $sale->seller->name ?? '—' }}</td>
                <td>{{ $sale->order->status }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="9">Nenhuma venda encontrada.</td>
            </tr>
        @endforelse
    </tbody>
</table>