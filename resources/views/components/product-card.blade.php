@props(['product'])

<div class="w-full max-w-sm bg-white p-6 border border-gray-200 rounded-2xl shadow-lg shadow-[#6B5744] text-center">
    <a href="#">
        <img class="rounded-lg mb-4 mx-auto" src="{{ asset('storage/' . $product->photo) }}" alt="{{ $product->name }}" />
    </a>
    <div>
        <a href="#">
            <h5 class="text-base text-gray-800 font-medium leading-snug mb-2"> {{ $product->name }} </h5>
        </a>
        <span class="block text-2xl font-semibold text-green-600 mb-4"> R$ {{ number_format($product->price, 2, ',', '.') }} </span>
            <div class="flex items-center justify-center gap-2">
                <a href="{{ route('product.detail', $product) }}"
                    class="flex justify-center items-center border-2 w-60 border-[#6B5744] text-[#6B5744] bg-[#6B5744]/15 font-medium rounded-md px-3 p-3 cursor-pointer">Saber mais
                </a>

                <form action="{{ route('cart.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">

                    @unless (auth()->user()->role === 'admin')
                        <button type="submit" class="bg-green-600 border-2 rounded-md border-[#1B5E3A] hover:bg-green-700 text-white p-3 transition cursor-pointer">
                            <x-heroicon-s-shopping-cart class="w-5 h-5" />
                        </button>
                    @endunless
                </form>
        </div>
    </div>
</div>