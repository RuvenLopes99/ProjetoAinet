<!-- filepath: c:\laragon\www\Ainet-Projeto\resources\views\components\orders\table.blade.php -->
<div>
    <table class="table-auto border-collapse w-full">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-left">ID</th>
            <th class="px-2 py-2 text-left">Member ID</th>
            <th class="px-2 py-2 text-left">Status</th>
            <th class="px-2 py-2 text-left">Date</th>
            <th class="px-2 py-2 text-left">Total Items</th>
            <th class="px-2 py-2 text-left">Shipping Cost</th>
            <th class="px-2 py-2 text-left">Total</th>
            <th class="px-2 py-2 text-left">NIF</th>
            <th class="px-2 py-2 text-left">Delivery Address</th>
            <th class="px-2 py-2 text-left">PDF Receipt</th>
            <th class="px-2 py-2 text-left">Cancel Reason</th>
            @if($showView ?? false)
                <th></th>
            @endif
            @if($showEdit ?? false)
                <th></th>
            @endif
            @if($showDelete ?? false)
                <th></th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($orders as $order)
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                <td class="px-2 py-2 text-left">{{ $order->id }}</td>
                <td class="px-2 py-2 text-left">{{ $order->member_id }}</td>
                <td class="px-2 py-2 text-left">{{ $order->status }}</td>
                <td class="px-2 py-2 text-left">{{ $order->date }}</td>
                <td class="px-2 py-2 text-left">{{ $order->total_items }}</td>
                <td class="px-2 py-2 text-left">{{ $order->shipping_cost }}</td>
                <td class="px-2 py-2 text-left">{{ $order->total }}</td>
                <td class="px-2 py-2 text-left">{{ $order->nif }}</td>
                <td class="px-2 py-2 text-left">{{ $order->delivery_address }}</td>
                <td class="px-2 py-2 text-left">{{ $order->pdf_receipt }}</td>
                <td class="px-2 py-2 text-left">{{ $order->cancel_reason }}</td>
                @if($showView ?? false)
                    <td class="ps-2 px-0.5">
                        <a href="{{ route('orders.show', ['order' => $order]) }}">
                            <flux:icon.eye class="size-5 hover:text-green-600" />
                        </a>
                    </td>
                @endif
                @if($showEdit ?? false)
                    <td class="px-0.5">
                        <a href="{{ route('orders.edit', ['order' => $order]) }}">
                            <flux:icon.pencil-square class="size-5 hover:text-blue-600" />
                        </a>
                    </td>
                @endif
                @if($showDelete ?? false)
                    <td class="px-0.5">
                        <form method="POST" action="{{ route('orders.destroy', ['order' => $order]) }}" class="flex items-center">
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
</div>
