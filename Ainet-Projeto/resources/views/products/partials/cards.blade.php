<div
    @php
        $highlightDiscount = !is_null($product->discount_min_qty) && !is_null($product->discount);
    @endphp
    class="bg-gray-900 rounded-lg shadow-md overflow-hidden flex flex-col items-center p-4 text-gray-900 border-3 border-black h-full {{ $highlightDiscount ? 'ring-4 ring-yellow-400' : '' }}"
>
    <img src="{{ asset('storage/products/' . $product->photo) }}"
         alt="{{ $product->name }}"
         class="w-40 h-40 object-cover mb-4 rounded-md border-3 border-black">

    <h2 class="text-white font-semibold mb-2">{{ $product->name }}</h2>
    <p class="text-gray-300 mb-4">{{ $product->category?->name }}</p>
    <p class="text-gray-400 mb-4">{{ $product->description }}</p>

    <p class="text-gray-400 mb-4">{{ $product->description }}</p>

    @if($highlightDiscount)
        <div class="mb-2 px-3 py-1 bg-yellow-400 text-gray-900 font-bold rounded-full">
            {{ $product->discount }}% OFF for {{ $product->discount_min_qty }}+
        </div>
    @endif

    @if($product->stock < $product->stock_lower_limit)
        <div class="mg-1 px-3 py-1 bg-red-600 text-white font-bold rounded">
            Out of stock (can still be ordered) !
        </div>
    @endif

    <div class="flex-grow"></div>

    <div class="flex-grow"></div>

    <div class="w-full flex flex-col items-center">
        <p class="text-green-600 font-bold text-xl mb-2">
            {{ number_format($product->price, 2) }} €
        </p>

        <form method="POST" action="{{ route('cart.add', $product->id) }}" class="w-full flex flex-col items-center">
            @csrf
            <div class="flex items-center space-x-3 mb-4">
                <button type="button"
                    onclick="changeQty('{{ $product->id }}', -1, {{ $product->price }}, {{ $product->discount ?? 0 }}, {{ $product->discount_min_qty ?? 0 }})"
                    class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">–</button>

                <input
                    id="qty-{{ $product->id }}"
                    name="quantity"
                    type="number"
                    value="0"
                    min="0"
                    class="w-12 text-center text-white bg-gray-800 rounded font-semibold"
                    readonly>

                <button type="button"
                    onclick="changeQty('{{ $product->id }}', 1, {{ $product->price }}, {{ $product->discount ?? 0 }}, {{ $product->discount_min_qty ?? 0 }})"
                    class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">+</button>
            </div>

            <div class="mb-4">
                <span class="text-white">Total: </span>
                <span id="total-{{ $product->id }}" class="text-yellow-400 font-bold">
                    0.00 €
                </span>
                <span id="discount-label-{{ $product->id }}" class="ml-2 text-green-400 font-semibold" style="display:none;">
                    (Discount applied!)
                </span>
            </div>

            <button type="submit"
                class="bg-yellow-500 hover:bg-yellow-300 text-white font-bold py-2 px-4 rounded-full flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m5-9v9m4-9v9m1-9h2a2 2 0 012 2v7a2 2 0 01-2 2h-2a2 2 0 01-2-2v-7a2 2 0 012-2z" />
                </svg>
                <span>Add to Cart</span>
            </button>
        </form>
    </div>
</div>

<script>
function changeQty(id, delta, price, discount = 0, discountMinQty = 0) {
    const input = document.getElementById('qty-' + id);
    let value = parseInt(input.value) || 0;
    value = Math.max(0, value + delta);
    input.value = value;

    let subtotal = value * price;
    let discountLabel = document.getElementById('discount-label-' + id);

    // Apply discount if applicable
    if (discount > 0 && discountMinQty > 0 && value >= discountMinQty) {
        subtotal = subtotal * (1 - discount / 100);
        if (discountLabel) discountLabel.style.display = '';
    } else {
        if (discountLabel) discountLabel.style.display = 'none';
    }

    document.getElementById('total-' + id).textContent = subtotal.toFixed(2) + ' €';
}
</script>
