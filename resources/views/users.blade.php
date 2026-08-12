<x-layouts.app active="usuarios" title="Gerenciar Usuários">

    <div x-data="{ showCreateModal: {{ $errors->any() ? 'true' : 'false' }}, editingUserId: null }">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-3xl font-bold text-[#4E6E6E]">Usuários</h1>
                <p class="text-sm text-[#8FA6A3]">{{ $users->total() }} usuários encontrados</p>
            </div>

            @unless (auth()->user()->role === 'user')
                <button type="button"
                    @click="showCreateModal = true"
                    class="inline-flex items-center gap-2 bg-[#4E6E6E] hover:bg-[#3a5555] text-white font-medium px-5 py-3 rounded-lg transition cursor-pointer">
                    <x-heroicon-o-plus class="w-5 h-5" />
                    Adicionar Usuário
                </button>
            @endunless
        </div>

        <!-- <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-6">
            <div class="flex-1">
                <x-search-bar route="admin.products.search" placeholder="Buscar produtos..." />
            </div>
        </div> -->

        <div class="bg-white rounded-xl shadow overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-[#4E6E6E]">
                    <tr>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">ID</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Nome</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">CPF</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Data de aniversário</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($users as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-center text-sm text-gray-500">{{ $user->id }}</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-500">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-500">{{ preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $user->cpf) }}</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-500">{{ \Carbon\Carbon::parse($user->birth_date)->format('d/m/Y') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-3">
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
            </table>
        </div>

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