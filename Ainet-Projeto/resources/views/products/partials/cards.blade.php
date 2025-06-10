<div
    class="bg-gray-900 rounded-lg shadow-md overflow-hidden flex flex-col items-center p-4 text-gray-900 border-3 border-black">

    <img src="{{ asset('storage/products/' . $product->photo) }}"
         alt="{{ $product->name }}"
         class="w-40 h-40 object-cover mb-4 rounded-md border-3 border-black">

    <h2 class="text-white font-semibold mb-2">{{ $product->name }}</h2>
    <p class="text-green-600 font-bold text-xl mb-2">{{ number_format($product->price, 2) }} €</p>

    <form method="POST" action="{{ route('cart.add', $product->id) }}" class="w-full flex flex-col items-center">
        @csrf
        <div class="flex items-center space-x-3 mb-4">
            <button type="button"
                onclick="changeQty('{{ $product->id }}', -1, {{ $product->price }})"
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
                onclick="changeQty('{{ $product->id }}', 1, {{ $product->price }})"
                class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">+</button>
        </div>

        <div class="mb-4">
            <span class="text-white">Total: </span>
            <span id="total-{{ $product->id }}" class="text-yellow-400 font-bold">
                0.00 €
            </span>
        </div>

        <button type="submit"
            class="bg-yellow-500 hover:bg-yellow-300 text-white font-bold py-2 px-4 rounded-full flex items-center space-x-2">
            <i class="fas fa-cart-plus"></i>
            <span>Add to Cart</span>
        </button>
    </form>
</div>

<script>
function changeQty(id, delta, price) {
    const input = document.getElementById('qty-' + id);
    let value = parseInt(input.value) || 0;
    value = Math.max(0, value + delta);
    input.value = value;

    // Update total price
    const total = (value * price).toFixed(2);
    document.getElementById('total-' + id).textContent = total + ' €';
}
</script>
