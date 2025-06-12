@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">‹ Voltar para Encomendas Pendentes</a>    
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3>Detalhes da Encomenda #{{ $order->id }}</h3>
            <strong>Estado:</strong> <span class="badge badge-primary">{{ ucfirst($order->status) }}</span>
        </div>
        <div class="card-body">
            <h4>Informação do Cliente</h4>
            <p><strong>Nome:</strong> {{ $order->member->name }}</p>
            <p><strong>Email:</strong> {{ $order->member->email }}</p>
            <p><strong>Morada de Entrega:</strong> {{ $order->delivery_address }}</p>
            <p><strong>NIF:</strong> {{ $order->nif }}</p>
            <hr>

            <h4>Itens da Encomenda</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Preço Unitário</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items_orders as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->unit_price, 2, ',', '.') }} €</td>
                        <td class="text-right">{{ number_format($item->subtotal, 2, ',', '.') }} €</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right"><strong>Subtotal Itens:</strong></td>
                        <td class="text-right">{{ number_format($order->total_items, 2, ',', '.') }} €</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right"><strong>Custos de Envio:</strong></td>
                        <td class="text-right">{{ number_format($order->shipping_costs, 2, ',', '.') }} €</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right"><h4>Total da Encomenda:</h4></td>
                        <td class="text-right"><h4>{{ number_format($order->total, 2, ',', '.') }} €</h4></td>
                    </tr>
                </tfoot>
            </table>
            <hr>

            <h4>Ações</h4>
            {{-- Mostra os botões apenas se a encomenda estiver pendente --}}
            @if ($order->status == 'pending')
                {{-- Botão para marcar como concluída --}}
                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="completed">
                    <button type="submit" class="btn btn-success">Marcar como Concluída</button>
                </form>

                {{-- Botão para cancelar (apenas para admins) --}}
                @if (Auth::user()->type == 'board')
                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="d-inline ml-2">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="canceled">
                    {{-- Opcional: Adicionar um campo para o motivo do cancelamento --}}
                    {{-- <input type="text" name="cancel_reason" placeholder="Motivo do cancelamento"> --}}
                    <button type="submit" class="btn btn-danger">Cancelar Encomenda</button>
                </form>
                @endif
            @else
                <p>Esta encomenda já foi processada.</p>
            @endif
        </div>
    </div>
</div>
@endsection