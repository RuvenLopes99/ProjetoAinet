<x-layouts.main-content :title="'Card #'.($card->id ?? '')"
                        heading="Card Details"
                        :subheading="'Card #'.($card->id ?? '')">
    <div class="flex flex-col space-y-6">
        <div class="max-full">
            <section>
                {{-- Adicionámos uma verificação para garantir que $card existe e tem um ID --}}
                @if (isset($card) && $card->id)
                    <div class="flex flex-wrap justify-start items-center gap-4 mb-4">
                        {{-- Forma mais explícita e segura de passar o parâmetro --}}
                        <flux:button variant="primary" href="{{ route('admin.cards.edit', ['card' => $card->id]) }}">Edit</flux:button>

                        <flux:button href="{{ route('admin.cards.create') }}">New</flux:button>
                        
                        {{-- Forma mais explícita e segura de passar o parâmetro --}}
                        <form method="POST" action="{{ route('admin.cards.destroy', ['card' => $card->id]) }}">
                            @csrf
                            @method('DELETE')
                            <flux:button variant="danger" type="submit">Delete</flux:button>
                        </form>
                    </div>
                @else
                    {{-- Esta mensagem aparecerá se a variável $card for o problema --}}
                    <div class="p-4 text-red-700 bg-red-100 rounded-lg">
                        <strong>Erro:</strong> A informação do cartão não está disponível e os botões de gestão não podem ser mostrados.
                    </div>
                @endif

                <div style="user-select: none; pointer-events: none;">
                    @include('cards.partials.fields', ['card' => $card, 'readonly' => true, 'disabled' => true])
                </div>
            </section>
        </div>
    </div>
</x-layouts.main-content>