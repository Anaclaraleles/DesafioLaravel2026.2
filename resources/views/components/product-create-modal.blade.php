<div class="bg-[#f1f1f1] rounded-xl shadow-xl w-full max-w-md overflow-hidden"
     @click.outside="showCreateModal = false">

    <div class="flex items-center justify-between bg-[#C7D6D4] px-6 py-4">
        <h2 class="text-lg font-semibold text-[#3a5555]">Adicionar Produto</h2>
        <button type="button" @click="showCreateModal = false" class="text-[#3a5555] hover:text-[#1f3535] transition cursor-pointer">
            <x-heroicon-o-x-mark class="w-6 h-6" />
        </button>
    </div>

    <div class="px-6 py-6">

        <form action="{{ route('products.create') }}" method="post" enctype="multipart/form-data">
            @csrf

            {{-- Upload de foto --}}
            <div class="flex flex-col items-center mb-6">
                <label class="text-sm font-medium text-gray-700 mb-2">Foto<span class="text-red-500">*</span></label>
                <input type="file" name="photo" class="bg-white"/>
                @error('photo')
                    <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                @enderror
            </div>

            {{-- Nome --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Nome<span class="text-red-500">*</span>
                </label>
                <input name="name" value="{{ old('name') }}" class="w-full bg-white border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#4E6E6E] resize-none"/>
                @error('name')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>

            {{-- Descrição --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Descrição<span class="text-red-500">*</span>
                </label>
                <textarea name="description" rows="2" class="w-full border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#4E6E6E] resize-none">{{ old('description') }}</textarea>
                @error('description')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>

            {{-- Categoria / Preço / Quantidade --}}
            <div class="grid grid-cols-3 gap-3 mb-4">
               <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Categoria<span class="text-red-500">*</span></label>
                    <select name="category" class="w-full border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#4E6E6E]">
                        <option value="" selected disabled>Selecione</option>
                        @foreach (config('product.categorias', []) as $categoria)
                            <option value="{{ $categoria }}" @selected(old('category') === $categoria)>
                                {{ $categoria }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Preço<span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" min="0" name="price" value="{{ old('price') }}" class="w-full border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#4E6E6E]"/>
                    @error('price')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Quantidade<span class="text-red-500">*</span></label>
                    <input type="number" min="0" name="quantity" value="{{ old('quantity') }}" class="w-full border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#4E6E6E]"/>
                    @error('quantity')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Botões --}}
            <div class="flex justify-center gap-4 mt-8">
                <button type="button" @click="showCreateModal = false" class="px-8 py-3 border-1 rounded-md bg-[#C7D6D4] text-[#3a5555] font-medium hover:bg-[#b7c9c6] transition cursor-pointer shadow-lg shadow-[#4E6E6E]">Cancelar</button>
                <button type="submit" class="px-8 py-3 rounded-md bg-[#4E6E6E] text-white font-medium hover:opacity-90 transition cursor-pointer shadow-lg shadow-[#4E6E6E]">Salvar</button>
            </div>

        </form>
    </div>
</div>