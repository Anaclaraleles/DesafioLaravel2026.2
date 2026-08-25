<x-layouts.app active="inicio" title="Produtos">
    <h1 class="text-4xl font-bold text-[#4E6E6E] text-center my-1">Nossos Produtos</h1>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-center gap-3">
        <x-search-bar route="products.search" placeholder="Buscar produtos..." />

        {{-- Categoria --}}
        <form method="GET" action="{{ route('inicio') }}">
            <div class="relative inline-flex">
                <select id="category" name="filter[category]" onchange="this.form.submit()"class="appearance-none cursor-pointer bg-[#4CAF50] hover:bg-[#43a047] text-white text-sm font-semibold
                        rounded-full pl-10 pr-9 h-10 min-w-[220px] border-0 focus:outline-none focus:ring-2 focus:ring-[#4CAF50]/50
                        transition-colors">
                    <option value="" class="text-gray-800">Todas as categorias</option>
                    <option value="Celular" class="text-gray-800" @selected(request('filter.category') === 'Celular')>Celular</option>
                    <option value="Caixa de som" class="text-gray-800" @selected(request('filter.category') === 'Caixa de som')>Caixa de som</option>
                    <option value="Fone de ouvido" class="text-gray-800" @selected(request('filter.category') === 'Fone de ouvido')>Fone de ouvido</option>
                </select>

                <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-white">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7"/>
                    </svg>
                </span>

                <span class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-white">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </span>
            </div>
        </form>
    </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>

        <div class="mt-8 flex justify-center">
            {{ $products->links() }}
        </div>
</x-layouts.app>