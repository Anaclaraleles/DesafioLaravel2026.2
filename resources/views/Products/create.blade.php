<div>
    <h1>Criar um Produto</h1>

    @if ($message = session()->get('message'))
        <div>{{ $message }}</div>
        <br>
    @endif

    <form action="{{ route('products.create') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div>
            <input name="name" placeholder="Nome" value="{{ old('name') }}" />
            @error('name')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <br>

        <div>
            <textarea name="description" placeholder="Descrição">{{ old('description') }}</textarea>
            @error('description')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <br>

        <div>
            <input name="category" placeholder="Categoria" value="{{ old('category') }}" />
            @error('category')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <br>

        <div>
            <input type="number" step="0.01" min="0" name="price" placeholder="Preço" value="{{ old('price') }}" />
            @error('price')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <br>

        <div>
            <input type="number" min="0" name="quantity" placeholder="Quantidade" value="{{ old('quantity') }}" />
            @error('quantity')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <br>

        <div>
            <input type="file" name="photo" />
            @error('photo')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <br>

        <button>Salvar</button>
    </form>
</div>