<div class="flex flex-col items-center justify-center gap-8 py-12 px-8 select-none">

    {{-- Count display --}}
    <div class="text-8xl font-extrabold tracking-tight text-white tabular-nums"
         style="font-variant-numeric: tabular-nums;">
        {{ $count }}
    </div>

    {{-- Buttons --}}
    <div class="flex items-center gap-4">
        <button wire:click="decrement"
                class="w-14 h-14 rounded-full border-2 border-[#3f3f46] text-2xl font-bold
                       text-[#9ca3af] hover:border-mw-500 hover:text-mw-500
                       transition-colors flex items-center justify-center"
                aria-label="Decrement">
            &minus;
        </button>
        <button wire:click="increment"
                class="w-14 h-14 rounded-full bg-mw-500 hover:bg-mw-600 text-white text-2xl font-bold
                       transition-colors flex items-center justify-center shadow-lg shadow-mw-900/40"
                aria-label="Increment">
            +
        </button>
    </div>

</div>
