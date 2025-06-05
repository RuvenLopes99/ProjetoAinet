{{-- resources/views/operations/show.blade.php --}}
<x-layouts.main-content :title="'Operation #'.$operation->id"
                        heading="Operation Details"
                        :subheading="'Operation #'.$operation->id">
    <div class="flex flex-col space-y-6">
        <div class="max-full">
            <section>
                <div class="flex flex-wrap justify-start items-center gap-4 mb-4">
                    <flux:button variant="primary" href="{{ route('operations.edit', ['operation' => $operation]) }}">Edit</flux:button>
                    <flux:button href="{{ route('operations.create') }}">New</flux:button>
                    <form method="POST" action="{{ route('operations.destroy', ['operation' => $operation]) }}">
                        @csrf
                        @method('DELETE')
                        <flux:button variant="danger" type="submit">Delete</flux:button>
                    </form>
                </div>
                <div class="mt-6 space-y-4">
                    <div><strong>Operation ID:</strong> {{ $operation->id }}</div>
                    <div><strong>Card ID:</strong> {{ $operation->card_id }}</div>
                    <div><strong>Type:</strong> {{ $operation->type }}</div>
                    <div><strong>Value:</strong> {{ $operation->value }}</div>
                    <div><strong>Date:</strong> {{ $operation->date }}</div>
                    <div><strong>Debit Type:</strong> {{ $operation->debit_type }}</div>
                    <div><strong>Credit Type:</strong> {{ $operation->credit_type }}</div>
                    <div><strong>Payment Type:</strong> {{ $operation->payment_type }}</div>
                    <div><strong>Payment Reference:</strong> {{ $operation->payment_reference }}</div>
                    <div><strong>Order ID:</strong> {{ $operation->order_id }}</div>
                </div>
            </section>
        </div>
    </div>
</x-layouts.main-content>
