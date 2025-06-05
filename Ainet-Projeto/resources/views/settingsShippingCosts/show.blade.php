<x-layouts.main-content :title="'Shipping Cost Setting #'.$settingsShippingCost->id"
                        heading="Shipping Cost Setting Details"
                        :subheading="'Shipping Cost Setting #'.$settingsShippingCost->id">
    <div class="flex flex-col space-y-6">
        <div class="max-full">
            <section>
                <div class="static sm:absolute -top-2 right-0 flex flex-wrap justify-start sm:justify-end items-center gap-4">
                    <flux:button variant="primary" href="{{ route('settingsShippingCosts.edit', ['settingsShippingCost' => $settingsShippingCost]) }}">Edit</flux:button>
                    <flux:button href="{{ route('settingsShippingCosts.create') }}">New</flux:button>
                    <form method="POST" action="{{ route('settingsShippingCosts.destroy', ['settingsShippingCost' => $settingsShippingCost]) }}">
                        @csrf
                        @method('DELETE')
                        <flux:button variant="danger" type="submit">Delete</flux:button>
                    </form>
                </div>
                <div class="mt-6 space-y-4">
                    <div><strong>ID:</strong> {{ $settingsShippingCost->id }}</div>
                    <div><strong>Min Value Threshold:</strong> {{ $settingsShippingCost->min_value_threshold }}</div>
                    <div><strong>Max Value Threshold:</strong> {{ $settingsShippingCost->max_value_threshold }}</div>
                    <div><strong>Shipping Cost:</strong> {{ $settingsShippingCost->shipping_cost }}</div>
                </div>
            </section>
        </div>
    </div>
</x-layouts.main-content>
