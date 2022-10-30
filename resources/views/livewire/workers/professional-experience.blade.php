<div>
    <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <form wire:submit.prevent="save">
x


                <div class="flex justify-end mt-4">
                    <x-primary-button wire:loading.remove wire:target="save">
                        {{ __('Save') }}
                    </x-primary-button>
                    <x-app.loading-indicator wire:loading wire:target="save" class="mt-2"/>
                </div>
            </form>
        </div>
    </div>
</div>
