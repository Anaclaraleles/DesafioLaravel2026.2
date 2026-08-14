@props(['active' => '', 'title' => null])

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ? $title . ' - ' . config('app.name') : config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/cep.js'])
</head>
<body class="min-h-screen bg-[#f1f1f1]">

    <x-sidebar :active="$active" />

    <main class="ml-0 sm:ml-64 p-4 sm:p-8">
        {{ $slot }}
    </main>

</body>
</html>