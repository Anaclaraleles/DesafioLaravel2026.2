@props(['active' => ''])
@php
    $isAdmin = auth()->user()->role === 'admin';
    $menuItems = $isAdmin
        ? [
            ['key' => 'inicio', 'label' => 'Início', 'route' => 'admin.inicio', 'icon' => 'home'],
            ['key' => 'usuarios', 'label' => 'Gerenciar Usuários', 'route' => 'admin.usuarios', 'icon' => 'users'],
            ['key' => 'produtos', 'label' => 'Gerenciar Produtos', 'route' => 'products.manage', 'icon' => 'cube'],
            ['key' => 'admins', 'label' => 'Gerenciar Admins', 'route' => 'admin.admins', 'icon' => 'shield-check'],
            ['key' => 'vendas', 'label' => 'Histórico de vendas', 'route' => 'admin.vendas', 'icon' => 'arrow-trending-up'],
        ]
        : [
            ['key' => 'inicio', 'label' => 'Início', 'route' => 'user.inicio', 'icon' => 'home'],
            ['key' => 'usuarios', 'label' => 'Gerenciar Usuários', 'route' => 'user.usuarios', 'icon' => 'users'],
            ['key' => 'produtos', 'label' => 'Gerenciar Produtos', 'route' => 'products.manage', 'icon' => 'cube'],
            ['key' => 'compras', 'label' => 'Histórico de compras', 'route' => 'user.compras', 'icon' => 'shopping-cart'],
            ['key' => 'vendas', 'label' => 'Histórico de vendas', 'route' => 'user.vendas', 'icon' => 'chart-bar'],
        ];
@endphp
<button data-drawer-target="sidebar" data-drawer-toggle="sidebar" aria-controls="sidebar" type="button"
    class="text-gray-600 bg-transparent rounded-lg ms-3 mt-3 p-2 inline-flex sm:hidden hover:bg-gray-100">
    <span class="sr-only">Abrir menu</span>
    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h10"/>
    </svg>
</button>
<aside id="sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen -translate-x-full sm:translate-x-0 transition-transform" aria-label="Sidebar">
    <div class="h-full flex flex-col bg-[#4E6E6E] text-white">
        
        <div class="flex flex-col items-center py-6 border-b border-white/20">
            <span class="font-semibold text-sm truncate max-w-[180px] text-center">Bem-vindo(a), {{ auth()->user()->name }}</span>
        </div>
        
        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
            @foreach ($menuItems as $item)
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                          {{ $active === $item['key'] ? 'bg-white/20 font-semibold' : 'hover:bg-white/10' }}">
                    <x-dynamic-component :component="'heroicon-o-' . $item['icon']" class="w-5 h-5 shrink-0" />
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>
        
        <div class="px-3 py-4 border-t border-white/20">
            <form method="POST" action="{{ route($isAdmin ? 'admin.logout' : 'user.logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm w-full hover:bg-white/10">
                    <x-heroicon-o-arrow-left-on-rectangle class="w-5 h-5 shrink-0" />
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>