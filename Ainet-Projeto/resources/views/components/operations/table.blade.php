<!-- filepath: c:\laragon\www\Ainet-Projeto\resources\views\components\operations\table.blade.php -->
<div>
    <table class="table-auto border-collapse">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-left">ID</th>
            <th class="px-2 py-2 text-left">Card ID</th>
            <th class="px-2 py-2 text-left">Type</th>
            <th class="px-2 py-2 text-left">Value</th>
            <th class="px-2 py-2 text-left">Date</th>
            <th class="px-2 py-2 text-left">Debit Type</th>
            <th class="px-2 py-2 text-left">Credit Type</th>
            <th class="px-2 py-2 text-left">Payment Type</th>
            <th class="px-2 py-2 text-left">Payment Reference</th>
            <th class="px-2 py-2 text-left">Order ID</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($operations as $operation)
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                <td class="px-2 py-2 text-left">{{ $operation->id }}</td>
                <td class="px-2 py-2 text-left">{{ $operation->card_id }}</td>
                <td class="px-2 py-2 text-left">{{ $operation->type }}</td>
                <td class="px-2 py-2 text-left">{{ $operation->value }}</td>
                <td class="px-2 py-2 text-left">{{ $operation->date }}</td>
                <td class="px-2 py-2 text-left">{{ $operation->debit_type }}</td>
                <td class="px-2 py-2 text-left">{{ $operation->credit_type }}</td>
                <td class="px-2 py-2 text-left">{{ $operation->payment_type }}</td>
                <td class="px-2 py-2 text-left">{{ $operation->payment_reference }}</td>
                <td class="px-2 py-2 text-left">{{ $operation->order_id }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
