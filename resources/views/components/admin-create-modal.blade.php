<div class="bg-[#f1f1f1] rounded-xl shadow-xl w-full max-w-xl max-h-[90vh] overflow-hidden flex flex-col"
     @click.outside="showCreateModal = false">

    <div class="flex items-center justify-between bg-[#C7D6D4] px-6 py-4">
        <h2 class="text-lg font-semibold text-[#3a5555]">Adicionar Administrador</h2>
        <button type="button" @click="showCreateModal = false" class="text-[#3a5555] hover:text-[#1f3535] transition cursor-pointer">
            <x-heroicon-o-x-mark class="w-6 h-6" />
        </button>
    </div>

    <div class="px-6 py-6 overflow-y-auto">

        <form action="{{ route('admin.create') }}" method="post" enctype="multipart/form-data">
            @csrf

            {{-- Upload de foto --}}
            <div class="flex flex-col items-center mb-6" x-data="{ photoPreview: null }">
                <label class="text-sm font-medium text-gray-700 mb-2">Foto</label>

                <div class="relative w-24 h-24 mb-2">
                    <label for="photo" class="flex items-center justify-center w-24 h-24 rounded-full bg-white border border-gray-300 overflow-hidden cursor-pointer">
                        <template x-if="photoPreview">
                            <img :src="photoPreview" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!photoPreview">
                            <x-heroicon-o-photo class="w-10 h-10 text-gray-300" />
                        </template>
                    </label>

                    <label for="photo" class="absolute bottom-0 right-0 flex items-center justify-center w-8 h-8 rounded-full bg-white border border-gray-300 cursor-pointer">
                        <x-heroicon-s-plus class="w-5 h-5 text-gray-500" />
                    </label>

                    <input type="file" name="photo" id="photo" accept="image/*" class="hidden"
                           @change="photoPreview = $event.target.files.length ? URL.createObjectURL($event.target.files[0]) : photoPreview"/>
                </div>

                @error('photo')
                    <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                @enderror
            </div>

            {{-- Nome / CPF --}}
            <div class="grid grid-cols-2 gap-3 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nome<span class="text-red-500">*</span>
                    </label>
                    <input name="name" value="{{ old('name') }}" class="w-full bg-white border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#4E6E6E]"/>
                    @error('name')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        CPF<span class="text-red-500">*</span>
                    </label>
                    <input name="cpf" value="{{ old('cpf') }}" class="w-full bg-white border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#4E6E6E]"/>
                    @error('cpf')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Email<span class="text-red-500">*</span>
                </label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full bg-white border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#4E6E6E]"/>
                @error('email')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>

            {{-- Senha / Confirmar Senha --}}
            <div class="grid grid-cols-2 gap-3 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Senha<span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password" class="w-full bg-white border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#4E6E6E]"/>
                    @error('password')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Confirmar Senha<span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password_confirmation" class="w-full bg-white border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#4E6E6E]"/>
                </div>
            </div>

            {{-- Data de Nascimento / Telefone --}}
            <div class="grid grid-cols-2 gap-3 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Data de Nascimento</label>
                    <input type="date" name="birth_date" value="{{ old('birth_date') }}" class="w-full bg-white border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#4E6E6E]"/>
                    @error('birth_date')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Telefone</label>
                    <input name="phone" value="{{ old('phone') }}" class="w-full bg-white border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#4E6E6E]"/>
                    @error('phone')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>


            {{-- CEP --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    CEP<span class="text-red-500">*</span>
                </label>
                <input name="cep" value="{{ old('cep') }}" id="cep" class="w-full bg-white border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#4E6E6E]" onblur="pesquisacep(this.value);"/>
                @error('cep')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>

            {{-- Logradouro --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Logradouro<span class="text-red-500">*</span>
                </label>
                <input name="street" value="{{ old('street') }}" id="rua" class="w-full bg-white border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#4E6E6E]"/>
                @error('street')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>

            {{-- Bairro / Complemento --}}
            <div class="grid grid-cols-2 gap-3 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Bairro<span class="text-red-500">*</span>
                    </label>
                    <input name="neighborhood" value="{{ old('neighborhood') }}" id="bairro" class="w-full bg-white border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#4E6E6E]"/>
                    @error('neighborhood')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Complemento</label>
                    <input name="complement" id="complemento" value="{{ old('complement') }}" class="w-full bg-white border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#4E6E6E]"/>
                    @error('complement')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Número / Cidade / Estado --}}
            <div class="grid grid-cols-3 gap-3 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Número<span class="text-red-500">*</span>
                    </label>
                    <input name="number" id="numero" value="{{ old('number') }}" class="w-full bg-white border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#4E6E6E]"/>
                    @error('number')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Cidade<span class="text-red-500">*</span>
                    </label>
                    <input name="city" value="{{ old('city') }}" id="cidade" class="w-full bg-white border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#4E6E6E]"/>
                    @error('city')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Estado<span class="text-red-500">*</span>
                    </label>
                    <input name="state" value="{{ old('state') }}" id="uf" class="w-full bg-white border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#4E6E6E]"/>
                    @error('state')
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