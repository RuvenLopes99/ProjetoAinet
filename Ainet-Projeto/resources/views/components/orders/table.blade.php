@php
    function sortUrl($column) {
        $direction = (request('sort') === $column && request('direction') === 'asc') ? 'desc' : 'asc';
        return request()->fullUrlWithQuery(['sort' => $column, 'direction' => $direction]);
    }
    function sortArrow($column) {
        if (request('sort') === $column) {
            return request('direction') === 'asc' ? '↑' : '↓';
        }
        return '';
    }
@endphp
<div>
    <table class="table-auto border-collapse w-full">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-left"><a href="{{ sortUrl('id') }}">ID {!! sortArrow('id') !!}</a></th>
            <th class="px-2 py-2 text-left"><a href="{{ sortUrl('member_id') }}">Member ID {!! sortArrow('member_id') !!}</a></th>
            <th class="px-2 py-2 text-left"><a href="{{ sortUrl('status') }}">Status {!! sortArrow('status') !!}</a></th>
            <th class="px-2 py-2 text-left"><a href="{{ sortUrl('date') }}">Date {!! sortArrow('date') !!}</a></th>
            <th class="px-2 py-2 text-left"><a href="{{ sortUrl('total_items') }}">Total Items {!! sortArrow('total_items') !!}</a></th>
            <th class="px-2 py-2 text-left"><a href="{{ sortUrl('shipping_cost') }}">Shipping Cost {!! sortArrow('shipping_cost') !!}</a></th>
            <th class="px-2 py-2 text-left"><a href="{{ sortUrl('total') }}">Total {!! sortArrow('total') !!}</a></th>
            <th class="px-2 py-2 text-left"><a href="{{ sortUrl('nif') }}">NIF {!! sortArrow('nif') !!}</a></th>
            <th class="px-2 py-2 text-left"><a href="{{ sortUrl('delivery_address') }}">Delivery Address {!! sortArrow('delivery_address') !!}</a></th>
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
