<x-layouts.app.sidebar>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Estatísticas do Grocery Club') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <h3 class="text-sm font-medium text-gray-500 uppercase">Total de Vendas</h3>
                    <p class="mt-2 text-3xl font-bold text-gray-900">
                        {{ number_format($totalSalesValue, 2) }} €
                    </p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <h3 class="text-sm font-medium text-gray-500 uppercase">Encomendas Concluídas</h3>
                    <p class="mt-2 text-3xl font-bold text-gray-900">
                        {{ $totalOrders }}
                    </p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <h3 class="text-sm font-medium text-gray-500 uppercase">Membros Ativos</h3>
                    <p class="mt-2 text-3xl font-bold text-gray-900">
                        {{ $totalMembers }}
                    </p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <h3 class="text-sm font-medium text-gray-500 uppercase">Membros do Conselho</h3>
                    <p class="mt-2 text-3xl font-bold text-gray-900">
                        {{ $totalBoardMembers }}
                    </p>
                </div>

            </div>

            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900">Mais Estatísticas</h3>
                <p class="mt-1 text-sm text-gray-600">
                    Pode adicionar gráficos e tabelas detalhadas aqui.
                </p>
            </div>

        </div>
    </div>
</x-layouts.app.sidebar>
