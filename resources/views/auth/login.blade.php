<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-white overflow-hidden">

    @if ($message = session()->get('message'))
        <div>{{ $message }}</div>
        <br>
    @endif

    <div class="flex h-screen">

       <div class="w-full md:w-1/2 lg:w-1/2 bg-green-100 flex items-center justify-center p-8">

            <div class="card bg-white w-full max-w-sm shadow-xl rounded-2xl">
                <div class="card-body p-8">

                    <div class="flex flex-col items-center">
                        <img src="{{ asset('images/logo.png') }}" alt="Ecotronic" class="h-30 w-auto object-contain">
                    </div>

                    <h1 class="text-2xl font-bold text-[#52BA56]  text-center">FAÇA LOGIN</h1>
                    <p class="text-sm text-gray-500 text-center mb-4">Seja bem-vindo(a)!</p>

                    <form action="{{ route('login') }}" method="post" id="login-form" class="space-y-4">
                        @csrf

                        <div>
                            <label class="text-sm font-medium text-gray-700">Email</label>
                            <div class="flex items-center gap-2 bg-green-50 border border-[#4CAF50] rounded-lg px-3 py-2 mt-1">
                                <x-heroicon-o-envelope class="w-6 h-6 text-green-600" />
                                <input class="bg-transparent outline-none w-full text-sm" name="email" type="email" placeholder="Digite seu email" value="{{ old('email') }}" />
                            </div>
                            @error('email')
                                <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-700">Senha</label>
                            <div class="flex items-center gap-2 bg-green-50 border border-[#4CAF50] rounded-lg px-3 py-2 mt-1">
                                <x-heroicon-o-lock-closed class="w-6 h-6 text-green-600" />
                                <input class="bg-transparent outline-none w-full text-sm" type="password" name="password" placeholder="Digite sua senha" id="password-field" />
                            </div>
                            @error('password')
                                <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <a href="#" class="text-sm font-semibold text-gray-700 hover:text-green-700 block">
                            Esqueceu sua senha?
                        </a>

                        <div class="flex justify-center items-center h-10">
                            <button class="btn h-full w-full lg:w-3/5 bg-[#4A7A5C] hover:bg-green-800 text-white border-none rounded-full mt-2 cursor-pointer" type="submit" form="login-form">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="hidden md:flex md:w-1/2 lg:w-1/2 bg-white items-center justify-center overflow-hidden">
            <img src="{{ asset('images/CapaLogin.png') }}" alt="Ilustração reciclagem eletrônicos" class="w-full h-full object-contain p-8">
        </div>

    </div>

    <script>
        function togglePassword() {
            const field = document.getElementById('password-field');
            field.type = field.type === 'password' ? 'text' : 'password';
        }
    </script>

</body>
</html>