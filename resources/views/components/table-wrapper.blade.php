<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="w-full overflow-x-auto md:overflow-x-visible">
        <table {{ $attributes->merge(['class' => 'w-full min-w-[1000px] md:min-w-0']) }}>
            {{ $slot }}
        </table>
    </div>
</div>