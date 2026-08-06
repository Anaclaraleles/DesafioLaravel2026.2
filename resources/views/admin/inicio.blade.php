<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50">

    <x-sidebar active="inicio" />

    <main class="ml-64 p-8">
        <h1 class="text-2xl font-bold text-gray-800">Bem vindo de volta</h1>
    </main>

</body>
</html>