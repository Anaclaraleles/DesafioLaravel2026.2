<div>
    <h1>Editar</h1>

    @if ($message = session()->get('message'))
        <div>{{ $message }}</div>
        <br>
    @endif

    <form action="{{ route('products.edit', $product) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')

        <div>
            <input name="name" placeholder="Nome" value="{{ old('name', $product->name) }}" /> 
            @error('name')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <br>

        <div>
            <textarea name="description" placeholder="Descrição">{{ old('description', $product->description) }}</textarea>
            @error('description')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <br>

        <div>
            <input name="category" placeholder="Categoria" value="{{ old('category', $product->category) }}" />
            @error('category')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <br>

        <div>
            <input type="number" step="0.01" min="0" name="price" placeholder="Preço" value="{{ old('price', $product->price) }}" />
            @error('price')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <br>

        <div>
            <input type="number" min="0" name="quantity" placeholder="Quantidade" value="{{ old('quantity', $product->quantity) }}" />
            @error('quantity')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <br>

        <div>
            <img src="{{ asset('storage/' . $product->photo) }}" alt="Product Picture" width="150">
            <input type="file" name="photo" />
        </div>

        <br>

        <button>Salvar</button>
    </form>
</div>