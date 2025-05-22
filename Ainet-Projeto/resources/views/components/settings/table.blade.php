<!-- filepath: c:\laragon\www\Ainet-Projeto\resources\views\components\settings\table.blade.php -->
<div>
    <table class="table-auto border-collapse">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-left">ID</th>
            <th class="px-2 py-2 text-left">Membership Fee</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($settings as $setting)
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500" style="height: 50px;">
                <td class="px-2 py-2 text-left align-middle">{{ $setting->id }}</td>
                <td class="px-2 py-2 text-left align-middle">{{ $setting->membership_fee }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
