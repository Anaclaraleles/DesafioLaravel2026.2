<x-layouts.app active="inicio" title="Produtos">
        <h1 class="text-4xl font-bold text-[#4E6E6E] text-center my-8">Nossos Produtos</h1>

        <x-search-bar route="user.products.search" placeholder="Buscar produtos..." />
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>

        <div class="mt-8 flex justify-center">
            {{ $products->links() }}
        </div>
</x-layouts.app>