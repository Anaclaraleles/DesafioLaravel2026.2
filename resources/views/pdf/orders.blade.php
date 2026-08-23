<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Histórico de Compras</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #333;
        }

        h1 {
            color: #4A7A5C;
            font-size: 25px;
            margin-bottom: 4px;
        }

        .subtitle {
            color: #2E3B2F;
            margin-bottom: 24px;
        }

        .item {
            border: 1px solid #e5e5e5;
            border-left: 4px solid #52BA56;
            border-radius: 6px;
            padding: 12px 16px;
            margin-bottom: 12px;
            overflow: hidden; /* contém os floats internos */
        }

        .item-header {
            overflow: hidden;
            margin-bottom: 8px;
        }

        .product-name {
            float: left;
            font-size: 14px;
            font-weight: bold;
            color: #333;
        }

        .valor {
            float: right;
            font-size: 14px;
            font-weight: bold;
            color: #2E7D32;
        }

        .item-meta {
            clear: both;
            color: #666;
        }

        .item-meta span {
            display: inline-block;
            margin-right: 16px;
        }

        .item-meta .label {
            color: #999;
            text-transform: uppercase;
            font-size: 9px;
            display: block;
        }

        .empty {
            text-align: center;
            color: #999;
            padding: 30px 0;
        }

        .footer {
            margin-top: 30px;
            font-size: 10px;
            color: #999;
            text-align: center;
        }
    </style>
</head>
<body>

    <h1>Histórico de Compras</h1>
    <p class="subtitle">
        {{ $user->name }} — gerado em {{ now()->format('d/m/Y H:i') }}
    </p>

    @forelse ($orderItems as $orderItem)
        <div class="item">
            <div class="item-header">
                <span class="product-name">
                    {{ $orderItem->product->name }}
                </span>
                <span class="valor">
                    R$ {{ number_format($orderItem->sub_total, 2, ',', '.') }}
                </span>
            </div>

            <div class="item-meta">
                <span>
                    <span class="label">Data</span>
                    {{ $orderItem->order->created_at->format('d/m/Y H:i') }}
                </span>
                <span>
                    <span class="label">Produto</span>
                    {{ $orderItem->product->name ?? '—' }}
                </span>
                <span>
                    <span class="label">Categoria</span>
                    {{ $orderItem->product->category ?? '—' }}
                </span>
                <span>
                    <span class="label">Comprado por</span>
                    {{ $orderItem->order->buyer->name ?? '—' }}
                </span>
                <span>
                    <span class="label">Vendido por</span>
                    {{ $orderItem->seller->name ?? '—' }}
                </span>
            </div>
        </div>
    @empty
        <p class="empty">Nenhuma compra encontrada.</p>
    @endforelse

    <p class="footer">
        Documento gerado automaticamente — {{ config('app.name') }}
    </p>

</body>
</html>