<div>
    <x-jet-action-section>
        <x-slot name="title">
            {{ __('Manage Email Lists') }}
        </x-slot>

        <x-slot name="description">
            Contains sets of emails.
        </x-slot>

        <x-slot name="content">
            <div class="space-y-6">
                @if ($this->eventlistings->isNotEmpty())
                    @foreach ($this->eventlistings as $listing)
                        <div class="flex items-center justify-between">
                            <div>
                                <a href="{{ route('eventlistings.show', ['eventlisting' => $listing->id]) }}" target="_blank">{{ $listing->name }}</a>
                                <small class="text-gray-400 ml-2">Emails total: {{ $listing->emails()->count() }}, in pool: {{ $listing->emails()->wherePivot('in_pool', true)->count() }}</small>
                            </div>

                            <div class="flex items-center">
                                <a href="{{ route('eventlistings.show', ['eventlisting' => $listing->id]) }}" class="cursor-pointer ml-6 text-sm text-gray-400 focus:outline-none">
                                    {{ __('Details') }}
                                </a>
                                <button class="cursor-pointer ml-6 text-sm text-red-500 focus:outline-none" wire:click="confirmingListingDeletion({{ $listing->id}})">
                                    {{ __('Delete') }}
                                </button>
                            </div>
                        </div>
                    @endforeach
                    @if($this->eventlistings->hasPages())
                        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                            {{ $this->eventlistings->fragment('eventlistings')->links() }}
                        </div>
                    @endif
                @else
                    <div>{{ __('No Email lists yet.') }}</div>
                @endif
            </div>
        </x-slot>
    </x-jet-action-section>

    <!-- Delete Confirmation Modal -->
    <x-jet-confirmation-modal wire:model="confirmingListingDeletion">
        <x-slot name="title">
            {{ __('Delete List') }}
        </x-slot>

        <x-slot name="content">
            @if($this->listingBeingDeleted)
                {{ __('Are you sure you want to delete connection :name?', ['name' => $this->listingBeingDeleted->name]) }}
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingListingDeletion')" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="deleteConnection" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>