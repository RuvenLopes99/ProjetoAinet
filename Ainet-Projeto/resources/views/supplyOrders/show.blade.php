{{-- resources/views/supplyOrders/show.blade.php --}}
<x-layouts.main-content :title="'Supply Order #'.$supplyOrder->id"
                        heading="Supply Order Details"
                        :subheading="'Supply Order #'.$supplyOrder->id">
    <div class="flex flex-col space-y-6">
        <div class="max-full">
            <section>
                <div class="flex flex-wrap justify-start items-center gap-4 mb-4">
                    <flux:button variant="primary" href="{{ route('supplyOrders.edit', ['supplyOrder' => $supplyOrder]) }}">Edit</flux:button>
                    <flux:button href="{{ route('supplyOrders.create') }}">New</flux:button>
                    <form method="POST" action="{{ route('supplyOrders.destroy', ['supplyOrder' => $supplyOrder]) }}">
                        @csrf
                        @method('DELETE')
                        <flux:button variant="danger" type="submit">Delete</flux:button>
                    </form>
                </div>
                <div class="mt-6 space-y-4">
                    <div><strong>Supply Order ID:</strong> {{ $supplyOrder->id }}</div>
                    <div><strong>Product ID:</strong> {{ $supplyOrder->product_id }}</div>
                    <div><strong>Registered By (User ID):</strong> {{ $supplyOrder->registered_by_user_id }}</div>
                    <div><strong>Status:</strong> {{ $supplyOrder->status }}</div>
                    <div><strong>Quantity:</strong> {{ $supplyOrder->quantity }}</div>
                </div>
            </section>
        </div>
    </div>
</x-layouts.main-content>
