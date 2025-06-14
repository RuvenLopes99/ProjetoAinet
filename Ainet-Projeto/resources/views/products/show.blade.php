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
                    <div style="user-select: none; pointer-events: none;">
                        @include('products.partials.fields', ['product' => $product, 'readonly' => true, 'disabled' => true])
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-layouts.main-content>
