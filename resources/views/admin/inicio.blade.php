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

    <main class="ml-64 p-8">
        <h1 class="text-2xl font-bold text-gray-800">Pagina de produtos</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>

         <div class="p-4">
            {{ $products->links() }}
        </div>

    </main>

</body>
</html>