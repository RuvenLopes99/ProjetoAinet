<x-layouts.main-content title="Categories"
                        heading="List of categories"
                        subheading="Manage the categories of the institution">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl ">
        <div class="flex justify-start ">
            <div class="my-4 p-6 ">
                <x-categories.filter-card
                    :filterAction="route('categories.index')"
                    :resetUrl="route('categories.index')"
                    :name="old('name', $name ?? '')"
                    :image="old('image', $image ?? '')"
                    class="mb-6"
                />
                <div class="flex items-center gap-4 mb-4">
                    <flux:button variant="primary" href="{{ route('categories.create') }}">Create a new Category</flux:button>
                </div>
                <div class="my-4 font-base text-sm text-gray-700 dark:text-gray-300">
                    <x-categories.table :categories="$allCategories"
                                       :showView="true"
                                       :showEdit="true"
                                       :showDelete="true"
                    />
                </div>
                <div class="mt-4">
                    {{ $allCategories->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layouts.main-content>
