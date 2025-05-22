<div>
    <table class="table-auto border-collapse">
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

            </tr>
        @endforeach
        </tbody>
    </table>
</div>
