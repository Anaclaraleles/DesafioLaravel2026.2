<x-layouts.app active="contato" title="Fale Conosco">

<form action="{{ route('messages.store') }}" method="POST" class="max-w-md mx-auto bg-white p-6 rounded-xl shadow">
    @csrf

    @if (session('success'))
        <div class="mb-4 text-sm text-green-600 bg-green-50 border border-green-200 rounded-md px-3 py-2">
            {{ session('success') }}
        </div>
    @endif

    <h1 class="text-lg font-semibold text-gray-800 mb-6">Fale Conosco</h1>

    {{-- Nome --}}
    <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome</label>
        <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}"
               class="w-full border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#4E6E6E]" />
        @error('name')
            <span class="text-xs text-red-500">{{ $message }}</span>
        @enderror
    </div>

    {{-- E-mail --}}
    <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
        <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}"
               class="w-full border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#4E6E6E]" />
        @error('email')
            <span class="text-xs text-red-500">{{ $message }}</span>
        @enderror
    </div>

    {{-- Mensagem --}}
    <div class="mb-6">
        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Mensagem</label>
        <textarea name="message" id="message" rows="5"
                  class="w-full border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#4E6E6E] resize-none">{{ old('message') }}</textarea>
        @error('message')
            <span class="text-xs text-red-500">{{ $message }}</span>
        @enderror
    </div>

    <button type="submit"
            class="w-full bg-[#4E6E6E] hover:bg-[#3a5555] text-white font-medium px-5 py-3 rounded-lg transition cursor-pointer">
        Enviar
    </button>
</form>
</x-layouts.app>