<x-filament-breezy::grid-section md=2 title="Signature" description="Create your signature.">
    <x-filament::card>
        <form wire:submit.prevent="submit({{ auth()->user()->id }})" class="space-y-6">

            {{ $this->form }}

            <div class="text-right">
                <x-filament::button type="submit" form="submit" class="align-right">
                    Submit!
                </x-filament::button>
            </div>
        </form>
    </x-filament::card>
</x-filament-breezy::grid-section>
