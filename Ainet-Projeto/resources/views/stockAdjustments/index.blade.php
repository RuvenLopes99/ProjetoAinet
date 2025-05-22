<x-layouts.main-content title="Stock Adjustments"
                        heading="List of stock adjustments"
                        subheading="Manage the stock adjustments">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl ">
        <div class="flex justify-start ">
            <div class="my-4 p-6 ">
                <div class="my-4 font-base text-sm text-gray-700 dark:text-gray-300">
                    <x-stockAdjustments.table :stockAdjustments="$stockAdjustments"
                    />
                </div>
                <div class="mt-4">
                    {{ $stockAdjustments->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layouts.main-content>
