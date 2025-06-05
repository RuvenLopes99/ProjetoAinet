{{-- resources/views/cards/show.blade.php --}}
<x-layouts.main-content :title="'Card #'.$card->id"
                        heading="Card Details"
                        :subheading="'Card #'.$card->id">
    <div class="flex flex-col space-y-6">
        <div class="max-full">
            <section>
                <div class="flex flex-wrap justify-start items-center gap-4 mb-4">
                    <flux:button variant="primary" href="{{ route('cards.edit', ['card' => $card]) }}">Edit</flux:button>
                    <flux:button href="{{ route('cards.create') }}">New</flux:button>
                    <form method="POST" action="{{ route('cards.destroy', ['card' => $card]) }}">
                        @csrf
                        @method('DELETE')
                        <flux:button variant="danger" type="submit">Delete</flux:button>
                    </form>
                </div>
                <div class="mt-6 space-y-4">
                    <div><strong>Card ID:</strong> {{ $card->id }}</div>
                    <div><strong>Card Number:</strong> {{ $card->card_number }}</div>
                    <div><strong>Balance:</strong> {{ $card->balance }}</div>
                    <div><strong>User ID:</strong> {{ $card->user_id }}</div>
                </div>
            </section>
        </div>
    </div>
</x-layouts.main-content>
