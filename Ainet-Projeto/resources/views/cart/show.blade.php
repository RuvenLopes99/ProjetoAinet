<x-layouts.main-content title="Cart" heading="Shopping Cart">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl ">
        <div class="flex justify-start ">
            @if(empty($cart) || count($cart) === 0)
                <div class="my-4 p-6 ">
                    <h2 class="text-2xl font-bold text-gray-700 dark:text-gray-300">Your cart is empty</h2>
                </div>
            @else
                <div class="my-4 p-6 ">
                    <x-cart.filter-card
                        :filterAction="route('cart.show')"
                        :resetUrl="route('cart.show')"
                    />
                    <div class="my-4 font-base text-sm text-gray-700 dark:text-gray-300">
                        <x-cart.table :carts="$cart" />
                    </div>

                    <div class="mt-12">
                        <div class="flex justify-between items-start space-x-10">
                            <form action="{{ route('cart.confirm') }}" method="POST">
                                @csrf
                                @method('POST')
                                <flux:button type="submit" class="mt-[0.7rem]" variant="primary">
                                    Order Now
                                </flux:button>
                            </form>
                            <form action="{{ route('cart.destroy') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <flux:button type="submit" class="mt-[0.7rem]" variant="danger">
                                    Clear Cart
                                </flux:button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layouts.main-content>
