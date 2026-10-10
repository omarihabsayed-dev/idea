@props(['name', 'title'])

<div
    x-data="{ show: false }"
    x-cloak
    style="display: none;"
    x-show="show"
    role="dialog"
    aria-modal="true"
    aria-labelledby="modal-{{ $name }}-title"
    tabindex="-1"
    @open-modal.window="if ($event.detail === @js($name)) show = true"
    @close-modal.window="show = false"
    @keydown.escape.window="show = false"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm"
>
    <div
        x-show="show"
        x-transition:enter="ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 -translate-y-4 scale-95"
        @click.away="show = false"
        class="w-full max-w-2xl max-h-[80dvh] overflow-auto rounded-xl border border-neutral-800 bg-neutral-950 p-6 shadow-xl"
    >
        <div class="flex justify-between items-center">
            <h2 id="modal-{{ $name }}-title" class="text-xl font-bold">{{ $title }}</h2>
            <button @click="show = false" aria-label="Close modal">
                <x-icons.close/>
            </button>
        </div>

        <div class="mt-4">
            {{ $slot }}
        </div>
    </div>
</div>