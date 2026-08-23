<x-layouts.app active="inicio" title="Produtos">
    <div class="max-w-5xl mx-auto p-6">

        {{-- Cabeçalho --}}
        <div class="flex items-center gap-3 mb-6">
            <h1 class="text-2xl font-bold text-teal-700">Carrinho de compras</h1>
        </div>

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded-lg">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($cart->items->isEmpty())
            <p class="text-gray-500">Seu carrinho está vazio.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">

                <div class="md:col-span-2 space-y-4">
                    @foreach ($cart->items as $item)
                        <div class="flex items-center gap-4 bg-[#f4f1ea] border border-[#cbb894] rounded-2xl p-4">

                            <div class="w-24 h-24 bg-white rounded-lg overflow-hidden flex items-center justify-center shrink-0">
                                @if ($item->product->photo)
                                    <img src="{{ asset('storage/' . $item->product->photo) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                @endif
                            </div>

                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-gray-800 leading-snug">
                                    {{ $item->product->name }}
                                </p>
                                <p class="text-green-600 font-bold mt-1">
                                    R$ {{ number_format($item->unit_price, 2, ',', '.') }}
                                </p>
                            </div>

                             {{-- Stepper de quantidade --}}
                            <form action="{{ route('cart.update', $item) }}" method="POST"
                                  x-data="{ quantity: {{ $item->quantity }}, max: {{ $item->product->quantity }} }"
                                  class="flex items-center border border-gray-300 rounded-md overflow-hidden shrink-0">
                                @csrf
                                @method('PUT')
 
                                <button type="button"
                                        @click="quantity = Math.max(1, quantity - 1); $el.closest('form').submit()"
                                        class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold cursor-pointer">
                                    &minus;
                                </button>
 
                                <span class="px-4 py-2 text-sm font-medium" x-text="quantity"></span>
 
                                <button type="button"
                                        @click="quantity = Math.min(max, quantity + 1); $el.closest('form').submit()"
                                        class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold cursor-pointer">
                                    +
                                </button>
 
                                <input type="hidden" name="quantity" :value="quantity">
                            </form>

                            <form action="{{ route('cart.destroy', $item) }}" method="POST"
                                  onsubmit="return confirm('Remover este item do carrinho?')" class="shrink-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700" title="Remover">
                                    <x-heroicon-o-trash class="w-5 h-5" />
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>

                {{-- Resumo da compra --}}
                <div class="bg-white border border-gray-200 rounded-2xl p-6 md:sticky md:top-6">
                    <h2 class="font-bold text-gray-800 uppercase tracking-wide mb-4">
                        Resumo da compra
                    </h2>

                    <div class="flex items-center justify-between mb-6">
                        <span class="text-gray-700">Total a pagar:</span>
                        <span class="text-green-600 font-bold text-lg">
                            R$ {{ number_format($cart->total, 2, ',', '.') }}
                        </span>
                    </div>

                    <form action="/checkout" method="POST">
                        @csrf                  
                        @if($cart->items->isEmpty()) disabled @endif
                        <input type="hidden" name="cart_items" value="{{ json_encode($cart->items) }}">
                        <button type="submit" class="w-full bg-green-500 cursor-pointer text-white font-bold py-3 rounded-lg">
                            @if($cart->items->isEmpty()) disabled @endif
                            Finalizar compra (PagSeguro)
                        </button>
                    </form>

                    <form action="{{ route('mercadopago.process') }}" method="POST">
                        @csrf    
           
                        <input type="hidden" name="cart_items" value="{{ json_encode($cart->items) }}">
                        <button type="submit" class="w-full bg-green-500 cursor-pointer text-white font-bold py-3 rounded-lg">
                        @if($cart->items->isEmpty()) disabled @endif    
                            Finalizar compra (Mercado Pago)
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>

    <script>
        function adjustQty(button, delta) {
            const form = button.closest('.qty-form');
            const input = form.querySelector('.qty-input');
            const max = parseInt(form.dataset.max, 10);

            let value = parseInt(input.value, 10) + delta;
            value = Math.max(1, Math.min(value, max));

            if (value === parseInt(input.value, 10)) {
                return;
            }

            input.value = value;
            form.submit();
        }
    </script>
</x-layouts.app>