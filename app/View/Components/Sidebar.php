<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebar extends Component
{
    public bool $isAdmin;
    public array $menuItems;
    /**
     * Create a new component instance.
     */
    public function __construct(public string $active = '')
    {
        $this->isAdmin = auth()->user()->role === 'admin';
        $this->menuItems = $this->isAdmin ? $this->adminMenu() : $this->userMenu();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebar');
    }

    private function adminMenu(): array
    {
        return [
            ['key' => 'inicio', 'label' => 'Início', 'route' => 'inicio', 'icon' => 'home'],
            ['key' => 'usuarios', 'label' => 'Gerenciar Usuários', 'route' => 'usuarios', 'icon' => 'users'],
            ['key' => 'produtos', 'label' => 'Gerenciar Produtos', 'route' => 'products.manage', 'icon' => 'cube'],
            ['key' => 'admins', 'label' => 'Gerenciar Admins', 'route' => 'admins', 'icon' => 'shield-check'],
            ['key' => 'vendas', 'label' => 'Histórico de Vendas', 'route' => 'sales', 'icon' => 'arrow-trending-up'],
            ['key' => 'mensagens', 'label' => 'Gerenciar Mensagens', 'route' => 'messages.index', 'icon' => 'envelope'],
        ];
    }

    private function userMenu(): array
    {
        return [
            ['key' => 'inicio', 'label' => 'Início', 'route' => 'inicio', 'icon' => 'home'],
            ['key' => 'carrinho', 'label' => 'Carrinho', 'route' => 'cart.index', 'icon' => 'shopping-cart'],
            ['key' => 'usuarios', 'label' => 'Gerenciar Perfil', 'route' => 'usuarios', 'icon' => 'user'],
            ['key' => 'produtos', 'label' => 'Gerenciar Produtos', 'route' => 'products.manage', 'icon' => 'cube'],
            ['key' => 'compras', 'label' => 'Histórico de Compras', 'route' => 'orders', 'icon' => 'clipboard-document-list'],
            ['key' => 'vendas', 'label' => 'Histórico de Vendas', 'route' => 'sales', 'icon' => 'arrow-trending-up'],
        ];
    }
}
