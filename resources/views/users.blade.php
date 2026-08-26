<x-layouts.app active="usuarios" title="Gerenciar Usuários">

    <div x-data="{
            showCreateModal: {{ $errors->any() && !old('_editing_user_id') ? 'true' : 'false' }},
            editingUserId: {{ old('_editing_user_id') ? old('_editing_user_id') : 'null' }}
         }">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                @if (auth()->user()->role === 'admin')
                    <h1 class="text-3xl font-bold text-[#4E6E6E]">Usuários</h1>
                    <p class="text-sm text-[#8FA6A3]">{{ $users->total() }} usuários encontrados</p>
                @else
                    <h1 class="text-3xl font-bold text-[#4E6E6E]">Meu Perfil</h1>
                @endif
            </div>

            @unless (auth()->user()->role === 'user')
                <button type="button"
                    @click="showCreateModal = true"
                    class="inline-flex items-center gap-2 bg-[#52BA56] hover:bg-[#3a5555] text-white font-medium px-5 py-3 rounded-lg transition cursor-pointer">
                    <x-heroicon-o-plus class="w-5 h-5" />
                    Adicionar Usuário
                </button>
            @endunless
        </div>

                <x-table-wrapper>
                    <thead class="bg-[#4E6E6E]">
                        <tr>
                            <x-table-header>ID</x-table-header>
                            <x-table-header>Nome</x-table-header>
                            <x-table-header>Email</x-table-header>
                            <x-table-header>CPF</x-table-header>
                            <x-table-header>Data de aniversário</x-table-header>
                            <x-table-header>Ações</x-table-header>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($users as $user)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-center text-sm text-gray-500">{{ $user->id }}</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-700">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-500">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-500">{{ formatCpf($user->cpf) }}</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-500">{{ formatDate($user->birth_date) }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-3">
                                        @if (auth()->user()->role === 'admin')
                                            <a href="{{ route('contact.index', ['user_id' => $user->id]) }}" class="text-blue-500 hover:text-blue-700 cursor-pointer" title="Enviar email">
                                                <x-heroicon-o-envelope class="w-5 h-5" />
                                            </a>
                                        @endif

                                        <button type="button" @click="editingUserId = {{ $user->id }}" class="text-yellow-500 hover:text-yellow-500 cursor-pointer" title="Editar">
                                            <x-heroicon-o-pencil-square class="w-5 h-5" />
                                        </button>

                                        <form action="{{ route('user.destroy', $user) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');">
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
                                    Nenhum usuário encontrado.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </x-table-wrapper>

        <div class="mt-8 flex justify-center">
            {{ $users->links() }}
        </div>

        {{-- Modal de criação de usuario --}}
        <div x-show="showCreateModal" x-cloak x-transition.opacity class="fixed inset-0 z-50 overflow-y-auto bg-black/70">
            <div class="flex min-h-full items-center justify-center p-4">
                <x-user-create-modal />
            </div>
        </div>

        {{-- Modais de edição de usuario --}}
        @foreach ($users as $user)
        <div x-show="editingUserId === {{ $user->id }}" x-cloak x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black/70">
            <x-user-edit-modal :user="$user" />
        </div>
        @endforeach

    </div>
</x-layouts.app>