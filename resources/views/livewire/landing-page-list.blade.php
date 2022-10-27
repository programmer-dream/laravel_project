<div>
    <x-action-section>
        <x-slot name="title">
            {{ __('Manage Pages') }}
        </x-slot>

        <x-slot name="content">
            <div class="space-y-6">
                @if($this->LandingPages->isNotEmpty())
                    @foreach($this->LandingPages as $landingpage)
                        <div class="flex items-center justify-between">
                            <div>
                                {{ $landingpage->slug }}
                            </div>

                            <div class="flex items-center">

                                <a href="{{ route('landingpages.edit', ['landingpage' => $landingpage->id]) }}" class="cursor-pointer ml-6 text-sm text-gray-400 focus:outline-none">
                                    {{ __('Edit') }}
                                </a>

                                <button class="cursor-pointer ml-6 text-sm text-red-500 focus:outline-none" wire:click="confirmLandingPageDeletion({{ $landingpage->id }})">
                                    {{ __('Delete') }}
                                </button>
                            </div>
                        </div>
                    @endforeach
                     @if($this->LandingPages->hasPages())
                        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                            {{ $this->LandingPages->fragment('')->links() }}
                        </div>
                    @endif
                @else
                    <div>{{ __('No templates yet.') }}</div>
                @endif

            </div>
        </x-slot>
    </x-action-section>

    <!-- Delete Confirmation Modal -->
    <x-jet-confirmation-modal wire:model="confirmingLandingpageDeletion">
        <x-slot name="title">
            {{ __('Delete Landing Page') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to delete this landing page?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingLandingpageDeletion')" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="deletePage" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
