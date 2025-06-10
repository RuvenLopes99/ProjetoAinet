<table class="table-auto border-collapse w-full">
    <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-left">ID</th>
            <th class="px-2 py-2 text-left">Order ID</th>
            <th class="px-2 py-2 text-left">Product ID</th>
            <th class="px-2 py-2 text-left">Quantity</th>
            <th class="px-2 py-2 text-left">Unit Price</th>
            <th class="px-2 py-2 text-left">Discount</th>
            <th class="px-2 py-2 text-left">Subtotal</th>
            @if($showView)
                <th></th>
            @endif
            @if($showEdit)
                <th></th>
            @endif
            @if($showDelete)
                <th></th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($itemsOrders as $itemsOrder)
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                <td class="px-2 py-2 text-left">{{ $itemsOrder->id }}</td>
                <td class="px-2 py-2 text-left">{{ $itemsOrder->order_id }}</td>
                <td class="px-2 py-2 text-left">{{ $itemsOrder->product_id }}</td>
                <td class="px-2 py-2 text-left">{{ $itemsOrder->quantity }}</td>
                <td class="px-2 py-2 text-left">{{ $itemsOrder->unit_price }}</td>
                <td class="px-2 py-2 text-left">{{ $itemsOrder->discount }}</td>
                <td class="px-2 py-2 text-left">{{ $itemsOrder->subtotal }}</td>
                @if($showView)
                    <td class="ps-2 px-0.5">
                        <a href="{{ route('itemsOrders.show', ['itemsOrder' => $itemsOrder]) }}">
                            <flux:icon.eye class="size-5 hover:text-green-600" />
                        </a>
                    </td>
                @endif
                @if($showEdit)
                    <td class="px-0.5">
                        <a href="{{ route('itemsOrders.edit', ['itemsOrder' => $itemsOrder]) }}">
                            <flux:icon.pencil-square class="size-5 hover:text-blue-600" />
                        </a>
                    </td>
                @endif
                @if($showDelete)
                    <td class="px-0.5">
                        <form method="POST" action="{{ route('itemsOrders.destroy', ['itemsOrder' => $itemsOrder]) }}" class="flex items-center">
                            @csrf
                            @method('DELETE')
                            <button type="submit">
                                <flux:icon.trash class="size-5 hover:text-red-600" />
                            </button>
                        </form>
                    </td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
