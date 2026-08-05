<div>
    <h1>Bem vindo de volta</h1>
</div>
<form method="POST" action="{{ route('admin.logout') }}">
    @csrf
    <button type="submit">Sair</button>
</form>