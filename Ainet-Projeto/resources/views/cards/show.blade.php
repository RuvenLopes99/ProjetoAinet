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
                <div style="user-select: none; pointer-events: none;">
                        @include('cards.partials.fields', ['card' => $card, 'readonly' => true, 'disabled' => true])
                    </div>
            </section>
        </div>
    </div>
</x-layouts.main-content>
