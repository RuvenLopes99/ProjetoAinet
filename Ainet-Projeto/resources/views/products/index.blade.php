<x-layouts.main-content title="Products"
                        heading="List of products"
                        subheading="Manage the products of the institution">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl ">
        <div class="flex justify-start ">
            <div class="my-4 p-6 ">
                <x-products.filter-card
                    :filterAction="route('products.index')"
                    :resetUrl="route('products.index')"
                    :name="old('name', $name)"
                    :categoryId="old('category_id', $categoryId)"
                    :price="old('price', $price)"
                    :outOfStock="old('outOfStock', $outOfStock)"
                    :belowThreshold="old('belowThreshold', $belowThreshold)"
                    class="mb-6"
                />
                <div class="flex items-center gap-4 mb-4">
                    <flux:button variant="primary" href="{{ route('products.create') }}">Create a new Product</flux:button>
                </div>
                <div class="my-4 font-base text-sm text-gray-700 dark:text-gray-300">
                    <x-products.table :products="$products"
                                     :showView="true"
                                     :showEdit="true"
                                     :showDelete="true"
                    />
                </div>
                <div class="mt-4">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layouts.main-content>
