@props(['product'])

<div class="bg-[#f1f1f1] rounded-2xl shadow-xl w-full max-w-md max-h-[90vh] overflow-y-auto"
     @click.outside="showEditModal = false">

    <div class="flex items-center justify-between bg-[#C7D6D4] px-6 py-4">
        <h2 class="text-lg font-semibold text-[#3a5555]">Editar Produto</h2>
        <button type="button" @click="editingProductId = null" class="text-[#3a5555] hover:text-[#1f3535] transition cursor-pointer">
            <x-heroicon-o-x-mark class="w-6 h-6" />
        </button>
    </div>

    <div class="px-6 py-6">

        <form action="{{ route('products.edit', $product) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')

            {{-- Foto--}}
            <div class="flex flex-col items-center mb-6">
                <img src="{{ asset('storage/' . $product->photo) }}" alt="{{ $product->name }}" class="w-20 h-20 object-cover rounded-md mb-3">
                <label class="text-sm font-medium text-gray-700 mb-2">Foto</label>
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
                <input name="name" value="{{ old('name', $product->name) }}" class="w-full bg-white border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#4E6E6E] resize-none"/>
                @error('name')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>

            {{-- Descrição --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Descrição<span class="text-red-500">*</span>
                </label>
                <textarea name="description" rows="2" class="w-full border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#4E6E6E] resize-none">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>

            {{-- Categoria / Preço / Quantidade --}}
            <div class="grid grid-cols-3 gap-3 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Categoria<span class="text-red-500">*</span></label>
                    <select name="category" class="w-full border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#4E6E6E]">
                        <option value="" disabled>Selecione</option>
                        <option value="celular" @selected(old('category', $product->category) === 'celular')>Celular</option>
                        <option value="fone" @selected(old('category', $product->category) === 'fone')>Fone de Ouvido</option>
                        <option value="carregador" @selected(old('category', $product->category) === 'carregador')>Carregador</option>
                        <option value="som" @selected(old('category', $product->category) === 'som')>Caixa de som</option>
                        <option value="outros" @selected(old('category', $product->category) === 'outros')>Outros</option>
                    </select>
                    @error('category')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Preço<span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $product->price) }}" class="w-full border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#4E6E6E]"/>
                    @error('price')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Quantidade<span class="text-red-500">*</span></label>
                    <input type="number" min="0" name="quantity" value="{{ old('quantity', $product->quantity) }}" class="w-full border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#4E6E6E]"/>
                    @error('quantity')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Botões --}}
            <div class="flex justify-center gap-4 mt-8">
                <button type="button" @click="editingProductId = null" class="px-8 py-3 border-1 rounded-lg bg-[#C7D6D4] text-[#3a5555] font-medium hover:bg-[#b7c9c6] transition cursor-pointer shadow-lg shadow-[#4E6E6E]">Cancelar</button>
                <button type="submit" class="px-8 py-3 rounded-lg bg-[#4E6E6E] text-white font-medium hover:opacity-90 transition cursor-pointer shadow-lg shadow-[#4E6E6E]">Salvar</button>
            </div>

        </form>
    </div>
</div>