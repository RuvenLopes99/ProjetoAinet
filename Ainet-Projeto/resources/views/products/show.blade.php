{{-- resources/views/products/show.blade.php --}}
<x-layouts.main-content :title="'Product #'.$product->id"
                        heading="Product Details"
                        :subheading="'Product #'.$product->id">
    <div class="flex flex-col space-y-6">
        <div class="max-full">
            <section>
                <div class="flex flex-wrap justify-start items-center gap-4 mb-4">
                    <flux:button variant="primary" href="{{ route('products.edit', ['product' => $product]) }}">Edit</flux:button>
                    <flux:button href="{{ route('products.create') }}">New</flux:button>
                    <form method="POST" action="{{ route('products.destroy', ['product' => $product]) }}">
                        @csrf
                        @method('DELETE')
                        <flux:button variant="danger" type="submit">Delete</flux:button>
                    </form>
                </div>
                <div class="mt-6 space-y-4">
                    <div><strong>Product ID:</strong> {{ $product->id }}</div>
                    <div><strong>Category ID:</strong> {{ $product->category_id }}</div>
                    <div><strong>Name:</strong> {{ $product->name }}</div>
                    <div><strong>Price:</strong> {{ $product->price }}</div>
                    <div><strong>Stock:</strong> {{ $product->stock }}</div>
                    <div><strong>Description:</strong> {{ $product->description }}</div>
                    <div><strong>Photo:</strong> {{ $product->photo }}</div>
                    <div><strong>Discount Min Qty:</strong> {{ $product->discount_min_qty }}</div>
                    <div><strong>Discount:</strong> {{ $product->discount }}</div>
                    <div><strong>Stock Lower Limit:</strong> {{ $product->stock_lower_limit }}</div>
                    <div><strong>Stock Upper Limit:</strong> {{ $product->stock_upper_limit }}</div>
                </div>
            </section>
        </div>
    </div>
</x-layouts.main-content>
