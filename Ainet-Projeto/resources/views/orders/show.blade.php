{{-- resources/views/orders/show.blade.php --}}
<x-layouts.main-content :title="'Order #'.$order->id"
                        heading="Order Details"
                        :subheading="'Order #'.$order->id">
    <div class="flex flex-col space-y-6">
        <div class="max-full">
            <section>
                <div class="flex flex-wrap justify-start items-center gap-4 mb-4">
                    <flux:button variant="primary" href="{{ route('orders.edit', ['order' => $order]) }}">Edit</flux:button>
                    <flux:button href="{{ route('orders.create') }}">New</flux:button>
                    <form method="POST" action="{{ route('orders.destroy', ['order' => $order]) }}">
                        @csrf
                        @method('DELETE')
                        <flux:button variant="danger" type="submit">Delete</flux:button>
                    </form>
                </div>
                <div class="mt-6 space-y-4">
                    <div><strong>Order ID:</strong> {{ $order->id }}</div>
                    <div><strong>Member (User ID):</strong> {{ $order->member_id }}</div>
                    <div><strong>Status:</strong> {{ $order->status }}</div>
                    <div><strong>Date:</strong> {{ $order->date }}</div>
                    <div><strong>Total Items:</strong> {{ $order->total_items }}</div>
                    <div><strong>Shipping Cost:</strong> {{ $order->shipping_cost }}</div>
                    <div><strong>Total:</strong> {{ $order->total }}</div>
                    <div><strong>NIF:</strong> {{ $order->nif }}</div>
                    <div><strong>Delivery Address:</strong> {{ $order->delivery_address }}</div>
                    <div><strong>PDF Receipt:</strong> {{ $order->pdf_receipt }}</div>
                    <div><strong>Cancel Reason:</strong> {{ $order->cancel_reason }}</div>
                </div>
            </section>
        </div>
    </div>
</x-layouts.main-content>
