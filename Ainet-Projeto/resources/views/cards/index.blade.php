<x-layouts.main-content title="Cards"
                        heading="List of cards"
                        subheading="Manage the cards of the institution">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl ">
        <div class="flex justify-start ">
            <div class="my-4 p-6 ">
                <x-cards.filter-card
                    :filterAction="route('cards.index')"
                    :resetUrl="route('cards.index')"
                    :cardNumber="old('card_number', $cardNumber ?? '')"
                    :balance="old('balance', $balance ?? '')"
                    class="mb-6"
                />
                <div class="flex items-center gap-4 mb-4">
                    <flux:button variant="primary" href="{{ route('cards.create') }}">Create a new Card</flux:button>
                </div>
                <div class="my-4 font-base text-sm text-gray-700 dark:text-gray-300">
                    <x-cards.table :cards="$cards"
                                  :showView="true"
                                  :showEdit="true"
                                  :showDelete="true"
                    />
                </div>
                <div class="mt-4">
                    {{ $cards->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layouts.main-content>
