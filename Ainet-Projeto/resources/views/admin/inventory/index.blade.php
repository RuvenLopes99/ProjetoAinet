@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gestão de Inventário</h1>
        {{-- Adicione este link --}}
        <a href="{{ route('admin.supply-orders.create') }}" class="btn btn-success">Criar Encomenda de Fornecimento</a>
    </div>

    {{-- Formulário de Filtros --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.inventory.index') }}" class="form-inline">
                <div class="form-group">
                    <label for="filter" class="mr-2">Filtrar por:</label>
                    <select name="filter" id="filter" class="form-control mr-2">
                        <option value="">Todos os Produtos</option>
                        <option value="low_stock" {{ $currentFilter == 'low_stock' ? 'selected' : '' }}>Stock Baixo</option>
                        <option value="out_of_stock" {{ $currentFilter == 'out_of_stock' ? 'selected' : '' }}>Esgotado</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </form>
        </div>
    </div>


    {{-- Tabela de Produtos --}}
    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th class="text-center">Stock Atual</th>
                        <th class="text-center">Limite Inferior</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td class="text-center">{{ $product->stock }}</td>
                            <td class="text-center">{{ $product->stock_lower_limit }}</td>
                            <td class="text-center">
                                @if ($product->stock == 0)
                                    <span class="badge badge-danger">Esgotado</span>
                                @elseif ($product->stock <= $product->stock_lower_limit)
                                    <span class="badge badge-warning">Stock Baixo</span>
                                @else
                                    <span class="badge badge-success">OK</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.inventory.adjust.form', $product) }}" class="btn btn-secondary btn-sm">Ajustar Stock</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Nenhum produto encontrado com os filtros selecionados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Links de Paginação --}}
    <div class="mt-4">
        {{ $products->appends(request()->query())->links() }}
    </div>
</div>
@endsection