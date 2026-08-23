<x-layouts.app active="produtos" title="Gerenciar Produtos">

    <div x-data="{ showCreateModal: {{ $errors->any() ? 'true' : 'false' }}, editingProductId: null }">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-3xl font-bold text-[#4E6E6E]">Produtos</h1>
                <p class="text-sm text-[#8FA6A3]">{{ $products->total() }} produtos encontrados</p>
            </div>

            @unless (auth()->user()->role === 'admin')
                <button type="button"
                    @click="showCreateModal = true"
                    class="inline-flex items-center gap-2 bg-[#52BA56] hover:bg-[#3a5555] text-white font-medium px-5 py-3 rounded-lg transition cursor-pointer">
                    <x-heroicon-o-plus class="w-5 h-5" />
                    Adicionar Produto
                </button>
            @endunless
        </div>

        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="w-full overflow-x-auto md:overflow-x-visible">
                <table class="w-full min-w-[1000px] md:min-w-0">
                    <thead class="bg-[#4E6E6E]">
                        <tr>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Foto</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Nome</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Categoria</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Preço</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Usuário</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($products as $product)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-center text-sm text-gray-500">{{ $product->id }}</td>
                                <td class="px-6 py-4 text-center">
                                    <img src="{{ asset('storage/' . $product->photo) }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded-md mx-auto">
                                </td>
                                <td class="px-6 py-4 text-center text-sm text-gray-700">{{ $product->name }}</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-500">{{ $product->category }}</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-700">R$ {{ formatPrice($product->price) }}</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-500">{{ $product->user->name }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-3">
                                        <button type="button" @click="editingProductId = {{ $product->id }}" class="text-yellow-500 hover:text-yellow-500 cursor-pointer" title="Editar">
                                            <x-heroicon-o-pencil-square class="w-5 h-5" />
                                        </button>
                                        <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este produto?');">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="text-red-500 flex items-center justify-center hover:text-red-700 cursor-pointer" title="Excluir">
                                                <x-heroicon-o-trash class="w-5 h-5" />
                                            </button>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-sm text-gray-400">
                                    Nenhum produto encontrado.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8 flex justify-center">
            {{ $products->links() }}
        </div>

        @if (auth()->user()->role === 'admin')
            <div class="mt-8">
                {!! $chart->renderHtml() !!}
                {!! $chart->renderJs() !!}
            </div>
        @endif

        {{-- Modal de criação de produto --}}
        <div x-show="showCreateModal" x-cloak x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black/70">
            <x-product-create-modal />
        </div>

        {{-- Modais de edição de produto --}}
        @foreach ($products as $product)
        <div x-show="editingProductId === {{ $product->id }}" x-cloak x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black/70">
            <x-product-edit-modal :product="$product" />
        </div>
        @endforeach

    </div>
</x-layouts.app>