@props(['active' => '', 'title' => null])

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ? $title . ' - ' . config('app.name') : config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/cep.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4"></script>
</head>
<body class="min-h-screen bg-[#f1f1f1]">

    <x-sidebar :active="$active" />

    <div class="sm:ml-64 flex flex-col min-h-screen">
        <x-navbar />

        <main class="flex-1 p-6">
            {{ $slot }}
        </main>
    </div>

</body>
</html>