<x-layouts.app active="mensagens" title="Gerenciar Mensagens">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-bold text-[#4E6E6E]">Mensagens</h1>
            <p class="text-sm text-[#8FA6A3]">{{ $messages->total() }} mensagens encontradas</p>
        </div>
    </div>

            <x-table-wrapper>
                <thead class="bg-[#4E6E6E]">
                    <tr>
                        <x-table-header>ID</x-table-header>
                        <x-table-header>Nome</x-table-header>
                        <x-table-header>Email</x-table-header>
                        <x-table-header>Mensagem</x-table-header>
                        <x-table-header>Data</x-table-header>
                        <x-table-header>Status</x-table-header>
                        <x-table-header>Ações</x-table-header>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($messages as $message)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-center text-sm text-gray-500">{{ $message->id }}</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700">{{ $message->name }}</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-500">{{ $message->email }}</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-500 max-w-xs truncate">
                                {{ \Illuminate\Support\Str::limit($message->message, 60) }}
                            </td>
                            <td class="px-6 py-4 text-center text-sm text-gray-500">{{ formatDate($message->created_at) }}</td>
                            <td class="px-6 py-4 text-center">
                                @if ($message->is_answered)
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                        Respondida
                                    </span>
                                @else
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                        Pendente
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-3">
                                    <a href="{{ route('messages.reply', $message) }}" class="text-blue-500 hover:text-blue-700 cursor-pointer" title="Responder por email">
                                        <x-heroicon-o-envelope class="w-5 h-5" />
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-sm text-gray-400">
                                Nenhuma mensagem encontrada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </x-table-wrapper>

    <div class="mt-8 flex justify-center">
        {{ $messages->links() }}
    </div>

</x-layouts.app>
