<x-layouts.app> {{-- A tag do seu componente de layout principal --}}
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Encomendas Pendentes</h1>
        </div>

        @if($orders->isEmpty())
            <div class="alert alert-info">
                Não existem encomendas pendentes de momento.
            </div>
        @else
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID da Encomenda</th>
                                <th>Cliente</th>
                                <th>Data</th>
                                <th class="text-right">Total</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody> {{-- CORRIGIDO --}}
                            @foreach ($orders as $order)
                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>{{ $order->member->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($order->date)->format('d/m/Y') }}</td>
                                    <td class="text-right">{{ number_format($order->total, 2, ',', '.') }} €</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-primary btn-sm">Gerir</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody> {{-- CORRIGIDO --}}
                    </table>
                </div>
            </div>

            {{-- Links de paginação --}}
            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</x-layouts.app>