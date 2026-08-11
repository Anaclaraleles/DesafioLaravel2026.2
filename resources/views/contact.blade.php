<x-layouts.app active="Gerenciar Produtos" title="Gerenciar Produtos">

<form action="{{ route('contact.store') }}" method="POST" class="max-w-md mx-auto bg-white p-6 rounded-xl shadow">
    @csrf

    {{-- Nome --}}
    <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}"
               class="w-full border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#4E6E6E]" />
        @error('name')
            <span class="text-xs text-red-500">{{ $message }}</span>
        @enderror
    </div>

    {{-- Email --}}
    <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}"
               class="w-full border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#4E6E6E]" />
        @error('email')
            <span class="text-xs text-red-500">{{ $message }}</span>
        @enderror
    </div>

    {{-- Assunto --}}
    <div class="mb-4">
        <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Assunto</label>
        <input type="text" name="subject" id="subject" value="{{ old('subject') }}"
               class="w-full border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#4E6E6E]" />
        @error('subject')
            <span class="text-xs text-red-500">{{ $message }}</span>
        @enderror
    </div>

    {{-- Mensagem --}}
    <div class="mb-6">
        <label for="text" class="block text-sm font-medium text-gray-700 mb-1">Mensagem</label>
        <textarea name="text" id="text" rows="4"
                  class="w-full border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#4E6E6E] resize-none">{{ old('text') }}</textarea>
        @error('text')
            <span class="text-xs text-red-500">{{ $message }}</span>
        @enderror
    </div>

    {{-- Botão --}}
    <button type="submit"
            class="w-full bg-[#4E6E6E] hover:bg-[#3a5555] text-white font-medium px-5 py-3 rounded-lg transition cursor-pointer">
        Enviar
    </button>

</form>
</x-layouts.app>