@props(['contentClasses' => 'bg-white rounded-lg shadow-xl overflow-hidden'])

<div class="relative">
    {{-- Trigger --}}
    <div class="cursor-pointer">
        {{ $trigger }}
    </div>

    {{-- Overlay for mobile to close when clicking outside --}}
    <div x-show="open"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-30 md:hidden"
         @click="open = false"
         style="display: none;">
    </div>

    {{-- Dropdown Content --}}
    <div x-show="open"
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         style="display: none;"
         class="fixed z-40 top-16 mt-2 inset-x-4 w-auto max-h-[80vh] overflow-y-auto shadow-lg
                md:absolute md:top-full md:inset-auto md:right-0 md:w-96"
         >
        <div class="{{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>
