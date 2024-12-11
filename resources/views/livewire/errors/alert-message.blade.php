<div>
    @if ($show)
        <div
            class="fixed top-4 left-1/2 transform -translate-x-1/2 max-w-lg w-full p-4 rounded-lg
            {{ $type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}"
            role="alert"
        >
            <div class="flex justify-between items-center">
                <span class="font-semibold">{{ $message }}</span>
                <button wire:click="$set('show', false)" class="ml-4 text-white">&times;</button>
            </div>
        </div>
    @endif
</div>

@push('scripts')
    <script>
        window.addEventListener('hideAlert', event => {
            setTimeout(() => {
                Livewire.emit('showAlert', '', ''); // Reinicia o alerta
            }, event.detail.delay);
        });
    </script>
@endpush
