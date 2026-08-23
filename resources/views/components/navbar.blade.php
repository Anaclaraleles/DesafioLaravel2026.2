<nav class="bg-white border-b border-gray-200 px-6 h-17 flex items-center justify-between shadow-sm">
    <img src="{{ asset('images/logo2.png') }}" alt="Logo" class="max-h-25 object-contain">

    <div class="flex items-center gap-3">
        <span class="text-sm font-medium text-gray-700">
            {{ auth()->user()->name }}
        </span>

        @if (auth()->user()->photo)
            <img src="{{ asset('storage/' . auth()->user()->photo) }}"
                 alt="{{ auth()->user()->name }}"
                 class="w-10 h-10 rounded-full object-cover border border-gray-200">
        @else
            <div class="w-10 h-10 rounded-full bg-[#4E6E6E] text-white flex items-center justify-center font-semibold text-sm">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
        @endif
    </div>
</nav>