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
                <div style="user-select: none; pointer-events: none;">
                        @include('supplyOrders.partials.fields', ['supplyOrder' => $supplyOrder, 'readonly' => true, 'disabled' => true])
                    </div>
            </section>
        </div>
    </div>
</x-layouts.main-content>
