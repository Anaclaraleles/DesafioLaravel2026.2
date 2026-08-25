@if (session('message'))
    <div class="mb-4 text-sm text-green-700 bg-green-50 border border-green-200 rounded-md px-4 py-3">
        {{ session('message') }}
    </div>
@endif

@if (session('error'))
    <div class="mb-4 text-sm text-red-700 bg-red-50 border border-red-200 rounded-md px-4 py-3">
        {{ session('error') }}
    </div>
@endif