<x-layouts.app active="inicio" title="Produto">

    <h1 class="text-2xl font-bold text-[#4E6E6E] text-center my-8">Detalhes do produto</h1>

    <div class="max-w-4xl mx-auto px-4" x-data="{ quantity: 1 }">

        <div class="p-6 bg-white flex flex-col sm:flex-row gap-6 mb-8">

            {{-- Foto --}}
            <div class="flex-shrink-0 flex items-center justify-center sm:w-64">
                <img src="{{ asset('storage/' . $product->photo) }}" alt="{{ $product->name }}" class="max-h-56 object-contain">
            </div>

            {{-- Informações --}}
            <div class="flex-1 flex flex-col justify-center">
                <h2 class="text-xl font-bold text-[#4E6E6E] mb-2">{{ $product->name }}</h2>
                <p class="text-2xl font-semibold text-[#4CAF50] mb-3">R$ {{ number_format($product->price, 2, ',', '.') }}</p>
                <p class="text-sm text-gray-600 mb-1">Categoria: {{ ucfirst($product->category) }}</p>
                <p class="text-sm text-gray-600 mb-6">Vendido por: {{ $product->user->name }}</p>

                @unless (auth()->user()->role === 'admin')
                <div class="flex flex-col sm:flex-row items-center gap-4">
                    <div class="flex items-center border border-gray-300 rounded-md overflow-hidden">
                        <button type="button" @click="quantity = Math.max(1, quantity - 1)" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold cursor-pointer">−</button>
                        <span class="px-4 py-2 text-sm font-medium" x-text="quantity"></span>
                        <button type="button" @click="quantity++" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold cursor-pointer">+</button>
                    </div>

                    <button type="button" class="flex-1 sm:flex-none bg-[#4CAF50] hover:bg-[#3a5555] text-white font-bold px-10 py-3 rounded-lg transition cursor-pointer">
                        COMPRAR
                    </button>
                </div>
                @endunless
            </div>
        </div>

        <div class="bg-[#0D2A4D]/11 rounded-xl p-6 mb-8">
            <h3 class="text-lg font-bold text-[#4E6E6E] mb-4">Descrição:</h3>
            <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">
                {{ $product->description }}
            </p>
        </div>

        {{-- Vendedor --}}
        <div class="flex justify-center mb-8">
            <div class="border-2 border-[#4CAF50] bg-[#4CAF50]/5 rounded-xl p-6 w-64 flex flex-col items-center">
                <h3 class="text-lg font-bold text-[#4CAF50] mb-4">Vendedor</h3>

                <div class="w-20 h-20 rounded-full bg-[#C7D6D4] flex items-center justify-center mb-3 overflow-hidden">
                    @if ($product->user->photo)
                        <img src="{{ asset('storage/' . $product->user->photo) }}" alt="{{ $product->user->name }}" class="w-full h-full object-cover">
                    @else
                        <x-heroicon-o-user class="w-10 h-10 text-[#4E6E6E]" />
                    @endif
                </div>

                <p class="font-semibold text-[#3a5555]">{{ $product->user->name }}</p>
                <p class="text-sm text-gray-500">{{ $product->user->phone}}</p>
            </div>
        </div>

    </div>

</x-layouts.app>