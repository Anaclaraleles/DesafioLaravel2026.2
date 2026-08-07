@props([
    'route',
    'placeholder' => 'Buscar...',
    'name' => 'search',
])

<form action="{{ route($route) }}" method="GET" class="flex justify-center my-6">
    <div class="relative w-full max-w-md">
        <input type="text" name="{{ $name }}" placeholder="{{ $placeholder }}" value="{{ request($name) }}" class="w-full bg-[#CFD8D6] h-10 text-[#4E6E6E] placeholder-[#6E8482] rounded-full border-2 border-[#8FA6A3] pl-6 pr-12 py-3 focus:outline-none focus:ring-2 focus:ring-[#4E6E6E] transition">
        <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 text-[#4E6E6E] hover:text-[#3a5555] transition cursor-pointer">
            <x-heroicon-o-magnifying-glass class="w-5 h-5" />
        </button>
    </div>
</form>