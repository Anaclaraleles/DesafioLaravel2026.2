<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f1f1f1]">

    <x-sidebar active="inicio" />

    <main class="ml-0 sm:ml-64 p-4 sm:p-8">
        <h1 class="text-4xl font-bold text-[#4E6E6E] text-center my-8">Nossos Produtos</h1>

        <x-search-bar route="admin.products.search" placeholder="Buscar produtos..." />

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>

        <div class="mt-8 flex justify-center">
            @if (isset($filters))
                {{ $products->appends($filters)->links() }}
            @else
                {{ $products->links() }}
            @endif
        </div>

    </main>

</body>
</html>