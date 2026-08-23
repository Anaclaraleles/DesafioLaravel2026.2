<x-layouts.app active="admins" title="Gerenciar Administradores">

    <div x-data="{
            showCreateModal: {{ $errors->any() && !old('_editing_admin_id') ? 'true' : 'false' }},
            editingAdminId: {{ old('_editing_admin_id') ? old('_editing_admin_id') : 'null' }}
         }">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-3xl font-bold text-[#4E6E6E]">Administradores</h1>
                <p class="text-sm text-[#8FA6A3]">{{ $admins->total() }} administradores encontrados</p>
            </div>

             @unless (auth()->user()->role === 'user')
                <button type="button"
                    @click="showCreateModal = true"
                    class="inline-flex items-center gap-2 bg-[#52BA56] hover:bg-[#3a5555] text-white font-medium px-5 py-3 rounded-lg transition cursor-pointer">
                    <x-heroicon-o-plus class="w-5 h-5" />
                    Adicionar Administrador
                </button>
            @endunless
        </div>

        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="w-full overflow-x-auto md:overflow-x-visible">
                <table class="w-full min-w-[1000px] md:min-w-0">
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
                        @forelse ($admins as $admin)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-center text-sm text-gray-500">{{ $admin->id }}</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-700">{{ $admin->name }}</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-500">{{ $admin->email }}</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-500">{{ formatCpf($admin->cpf) }}</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-500">{{ formatDate($admin->birth_date) }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-3">
                                        <button type="button" @click="editingAdminId = {{ $admin->id }}" class="text-yellow-500 hover:text-yellow-500 cursor-pointer" title="Editar">
                                            <x-heroicon-o-pencil-square class="w-5 h-5" />
                                        </button>
                                        <form action="{{ route('admin.destroy', $admin) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este administrador?');">
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
                                    Nenhum administrador encontrado.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8 flex justify-center">
            {{ $admins->links() }}
        </div>

        {{-- Modal de criação de usuario --}}
        <div x-show="showCreateModal" x-cloak x-transition.opacity class="fixed inset-0 z-50 overflow-y-auto bg-black/70">
            <div class="flex min-h-full items-center justify-center p-4">
                <x-admin-create-modal />
            </div>
        </div>

        {{-- Modais de edição de usuario --}}
        @foreach ($admins as $admin)
        <div x-show="editingAdminId === {{ $admin->id }}" x-cloak x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black/70">
            <x-admin-edit-modal :admin="$admin" />
        </div>
        @endforeach

    </div>
</x-layouts.app>