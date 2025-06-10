<x-layouts.main-content title="List of products">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-8 gap-6">
        @each('products.partials.cards', $products, 'product')
    </div>
    <div class="mt-6">
        {{ $products->links() }}
    </div>
</x-layouts.main-content>
