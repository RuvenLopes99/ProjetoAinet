<!-- filepath: c:\laragon\www\Ainet-Projeto\resources\views\components\supplyOrders\table.blade.php -->
<div>
    <table class="table-auto border-collapse">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-left">Supply Order ID</th>
            <th class="px-2 py-2 text-left">Product ID</th>
            <th class="px-2 py-2 text-left">Registered By User ID</th>
            <th class="px-2 py-2 text-left">Status</th>
            <th class="px-2 py-2 text-left">Quantity</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($supplyOrders as $supplyOrder)
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500" style="height: 50px;">
                <td class="px-2 py-2 text-left align-middle">{{ $supplyOrder->id }}</td>
                <td class="px-2 py-2 text-left align-middle">{{ $supplyOrder->product_id }}</td>
                <td class="px-2 py-2 text-left align-middle">{{ $supplyOrder->registered_by_user_id }}</td>
                <td class="px-2 py-2 text-left align-middle">{{ $supplyOrder->status }}</td>
                <td class="px-2 py-2 text-left align-middle">{{ $supplyOrder->quantity }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
