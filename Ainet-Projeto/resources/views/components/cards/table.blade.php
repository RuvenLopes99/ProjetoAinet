<!-- filepath: c:\laragon\www\Ainet-Projeto\resources\views\components\cards\table.blade.php -->
<div>
    <table class="table-auto border-collapse">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-left">ID</th>
            <th class="px-2 py-2 text-left">Card Number</th>
            <th class="px-2 py-2 text-left">Balance</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($cards as $card)
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                <td class="px-2 py-2 text-left">{{ $card->id }}</td>
                <td class="px-2 py-2 text-left">{{ $card->card_number }}</td>
                <td class="px-2 py-2 text-left">{{ $card->balance }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
