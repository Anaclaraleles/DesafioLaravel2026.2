<x-layouts.app active="Gerenciar Produtos" title="Gerenciar Produtos">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-bold text-[#4E6E6E]">Produtos</h1>
            <p class="text-sm text-[#8FA6A3]">{{ $products->total() }} produtos encontrados</p>
        </div>

        @unless (auth()->user()->role === 'admin')
            <a href="{{ route('products.create') }}" class="inline-flex items-center gap-2 bg-[#4E6E6E] hover:bg-[#3a5555] text-white font-medium px-5 py-3 rounded-lg transition">
                <x-heroicon-o-plus class="w-5 h-5" />
                Adicionar Produto
            </a>
        @endunless
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-6">
        <div class="flex-1">
            <x-search-bar route="admin.products.search" placeholder="Buscar produtos..." />
        </div>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="min-w-full">
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
                        <td class="px-6 py-4 text-center text-sm text-gray-700">R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                        <td class="px-6 py-4 text-center text-sm text-gray-500">{{ $product->user->name }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-3">
                                <a href="{{ route('products.edit', $product) }}" class="text-yellow-500 hover:text-yellow-500" title="Editar">
                                    <x-heroicon-o-pencil-square class="w-5 h-5" />
                                </a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este produto?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="text-red-500 hover:text-red-700" title="Excluir">
                                        <x-heroicon-o-trash class="w-5 h-5" />
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-400">
                            Nenhum produto encontrado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-8 flex justify-center">
        {{ $products->links() }}
    </div>

</x-layouts.app>