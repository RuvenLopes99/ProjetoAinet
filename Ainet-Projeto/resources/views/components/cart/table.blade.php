@if(empty($carts) || count($carts) === 0)
    <div class="p-4 text-center text-gray-500">
        Your cart is empty.
    </div>
@else
    <table class="min-w-full bg-white dark:bg-zinc-800 rounded shadow">
        <thead>
            <tr>
                <th class="px-4 py-2 text-left">Product</th>
                <th class="px-4 py-2 text-left">Quantity</th>
                <th class="px-4 py-2 text-left">Price</th>
                <th class="px-4 py-2 text-left">Subtotal</th>
                <th class="px-4 py-2"></th>
            </tr>
        </thead>
        <tbody>
            @php
                $total = 0;
            @endphp
            @foreach($carts as $productId => $quantity)
                @php
                    $product = \App\Models\Product::find($productId);
                    $subtotal = $product ? $product->price * $quantity : 0;
                    $total += $subtotal;
                @endphp
                <tr>
                    <td class="border-t px-4 py-2">
                        @if($product)
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('storage/products/' . $product->photo) }}" alt="{{ $product->name }}" class="w-10 h-10 object-cover rounded">
                                <span>{{ $product->name }}</span>
                            </div>
                        @else
                            <span class="text-red-500">Product not found</span>
                        @endif
                    </td>
                    <td class="border-t px-4 py-2">{{ $quantity }}</td>
                    <td class="border-t px-4 py-2">{{ $product ? number_format($product->price, 2) : 'N/A' }} €</td>
                    <td class="border-t px-4 py-2">{{ $product ? number_format($subtotal, 2) : '0.00' }} €</td>
                    <td class="border-t px-4 py-2">
                        <form action="{{ route('cart.remove', $productId) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-red-600 hover:underline">Remove</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3" class="text-right font-bold px-4 py-2">Total:</td>
                <td class="font-bold px-4 py-2">{{ number_format($total, 2) }} €</td>
                <td></td>
            </tr>
        </tbody>
    </table>
@endif
