<x-layouts.app active="mensagens" title="Responder Mensagem">

<div class="max-w-md mx-auto">

    <div class="bg-white p-6 rounded-xl shadow mb-4">
        <h2 class="text-sm font-semibold text-gray-700 mb-3">Mensagem recebida</h2>
        <div class="text-sm text-gray-600 bg-gray-50 border border-gray-200 rounded-md px-3 py-3">
            <p class="mb-2"><strong>De:</strong> {{ $message->name }} ({{ $message->email }})</p>
            <p class="mb-2"><strong>Data:</strong> {{ formatDate($message->created_at, 'd/m/Y H:i') }}</p>
            <p class="whitespace-pre-line">{{ $message->message }}</p>
        </div>
    </div>

    <form action="{{ route('messages.reply.store', $message) }}" method="POST" class="bg-white p-6 rounded-xl shadow">
        @csrf

        @if (session('success'))
            <div class="mb-4 text-sm text-green-600 bg-green-50 border border-green-200 rounded-md px-3 py-2">
                {{ session('success') }}
            </div>
        @endif

        <input type="hidden" name="recipient_email" value="{{ $message->email }}">
        <input type="hidden" name="recipient_user" value="{{ $message->name }}">

        <div class="mb-4 text-sm text-gray-600 bg-gray-50 border border-gray-200 rounded-md px-3 py-2">
            Enviando para: <strong>{{ $message->name }}</strong> ({{ $message->email }})
        </div>

        {{-- Assunto --}}
        <div class="mb-4">
            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Assunto</label>
            <input type="text" name="subject" id="subject" value="{{ old('subject', 'Resposta à sua mensagem') }}"
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

        <button type="submit"
                class="w-full bg-[#4E6E6E] hover:bg-[#3a5555] text-white font-medium px-5 py-3 rounded-lg transition cursor-pointer">
            Enviar
        </button>
    </form>
</div>
</x-layouts.app>