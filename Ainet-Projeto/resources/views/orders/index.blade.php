{{-- filepath: resources/views/orders/index.blade.php --}}
<x-layouts.main-content title="Orders"
                        heading="List of Orders"
                        subheading="Manage the orders of the institution">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl ">
        <div class="flex justify-start ">
            <div class="my-4 p-6 ">
                <div class="flex items-center gap-4 mb-4">
                    <flux:button variant="primary" href="{{ route('orders.create') }}">Create a new Order</flux:button>
                </div>
                <div class="my-4 font-base text-sm text-gray-700 dark:text-gray-300">
                    <x-orders.table :orders="$orders"
                                    :showView="true"
                                    :showEdit="true"
                                    :showDelete="true"
                    />
                </div>
                <div class="mt-4">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layouts.main-content>
