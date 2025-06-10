{{-- resources/views/stockAdjustments/show.blade.php --}}
<x-layouts.main-content :title="'Stock Adjustment #'.$stockAdjustment->id"
                        heading="Stock Adjustment Details"
                        :subheading="'Stock Adjustment #'.$stockAdjustment->id">
    <div class="flex flex-col space-y-6">
        <div class="max-full">
            <section>
                <div class="flex flex-wrap justify-start items-center gap-4 mb-4">
                    <flux:button variant="primary" href="{{ route('stockAdjustments.edit', ['stockAdjustment' => $stockAdjustment]) }}">Edit</flux:button>
                    <flux:button href="{{ route('stockAdjustments.create') }}">New</flux:button>
                    <form method="POST" action="{{ route('stockAdjustments.destroy', ['stockAdjustment' => $stockAdjustment]) }}">
                        @csrf
                        @method('DELETE')
                        <flux:button variant="danger" type="submit">Delete</flux:button>
                    </form>
                </div>
                <div style="user-select: none; pointer-events: none;">
                        @include('stockAdjustments.partials.fields', ['stockAdjustment' => $stockAdjustment, 'readonly' => true, 'disabled' => true])
                    </div>
            </section>
        </div>
    </div>
</x-layouts.main-content>
