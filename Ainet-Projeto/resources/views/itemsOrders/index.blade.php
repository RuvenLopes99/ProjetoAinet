<x-layouts.main-content title="Item Orders"
                        heading="List of Item Orders"
                        subheading="Manage the item orders of the institution">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl ">
        <div class="flex justify-start ">
            <div class="my-4 p-6 ">
                <x-items-orders.filter-table
                    :filterAction="route('itemsOrders.index')"
                    :resetUrl="route('itemsOrders.index')"
                    class="mb-6"
                />
                <div class="flex items-center gap-4 mb-4">
                    <flux:button variant="primary" href="{{ route('itemsOrders.create') }}">Create a new Item Order</flux:button>
                </div>
                <div class="my-4 font-base text-sm text-gray-700 dark:text-gray-300">
                    <x-items-orders.table :itemsOrders="$itemsOrders"
                                         :showView="true"
                                         :showEdit="true"
                                         :showDelete="true"
                    />
                </div>
                <div class="mt-4">
                    {{ $itemsOrders->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layouts.main-content>
