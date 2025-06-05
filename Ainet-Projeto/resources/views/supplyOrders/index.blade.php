<!-- filepath: c:\laragon\www\Ainet-Projeto\resources\views\supplyOrders\index.blade.php -->
<x-layouts.main-content title="Supply Orders"
                        heading="List of stock supply orders"
                        subheading="Manage the supply orders">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl ">
        <div class="flex justify-start ">
            <div class="my-4 p-6 ">
                <div class="flex items-center gap-4 mb-4">
                    <flux:button variant="primary" href="{{ route('supplyOrders.create') }}">Create a new Supply Order</flux:button>
                </div>
                <div class="my-4 font-base text-sm text-gray-700 dark:text-gray-300">
                    <x-supplyOrders.table :supplyOrders="$supplyOrders"
                                         :showView="true"
                                         :showEdit="true"
                                         :showDelete="true"
                    />
                </div>
                <div class="mt-4">
                    {{ $supplyOrders->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layouts.main-content>
