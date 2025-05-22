<!-- filepath: c:\laragon\www\Ainet-Projeto\resources\views\components\products\table.blade.php -->
<div>
    <table class="table-auto border-collapse">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-left">ID</th>
            <th class="px-2 py-2 text-left">Name</th>
            <th class="px-2 py-2 text-left">Description</th>
            <th class="px-2 py-2 text-left">Price</th>
            <th class="px-2 py-2 text-left">Stock</th>
            <th class="px-2 py-2 text-left">Photo</th>
            <th class="px-2 py-2 text-left">Category ID</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($products as $product)
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500" style="height: 50px;">
                <td class="px-2 py-2 text-left align-middle">{{ $product->id }}</td>
                <td class="px-2 py-2 text-left align-middle">{{ $product->name }}</td>
                <td class="px-2 py-2 text-left align-middle">{!! nl2br(e($product->description)) !!}</td>
                <td class="px-2 py-2 text-left align-middle">{{ $product->price }}</td>
                <td class="px-2 py-2 text-left align-middle">{{ $product->stock }}</td>
                <td class="px-2 py-2 text-left align-middle">{{ $product->photo }}</td>
                <td class="px-2 py-2 text-left align-middle">{{ $product->category_id }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
