<x-layouts.main-content title="Cart" heading="Confirm Order">
    <form action="{{ route('cart.processConfirm') }}" method="POST" class="max-w-2xl mt-8 space-y-6">
        @csrf
        @method('POST')
        <div>
            <label class="block font-medium mb-1 text-white">Name</label>
            <input type="text" class="w-full rounded bg-zinc-800 border border-zinc-700 text-white px-3 py-2" value="{{ auth()->user()->name }}" disabled>
        </div>

        <div>
            <label for="nif" class="block font-medium mb-1 text-white">NIF</label>
            <input type="text" name="nif" id="nif" class="w-full rounded bg-zinc-800 border border-zinc-700 text-white px-3 py-2"
                value="{{ old('nif', auth()->user()->nif) }}" required placeholder="Enter your NIF">
        </div>

        <div>
            <label for="address" class="block font-medium mb-1 text-white">Address</label>
            <input type="text" name="address" id="address" class="w-full rounded bg-zinc-800 border border-zinc-700 text-white px-3 py-2"
                value="{{ old('address', auth()->user()->address) }}" required placeholder="Enter your address">
        </div>

        <div>
            <label class="block font-medium mb-2 text-white">Payment Method</label>
            @php
                $hasCard = isset($card) && $card->auth()->user()->id == auth()->user()->id;
            @endphp

            <div class="flex flex-col gap-2">
                @if($hasCard)
                    <label class="flex items-center gap-2 text-white">
                        <input type="radio" name="payment_method" value="saved_card" checked>
                        Use saved card (**** **** **** {{ substr($card->number, -4) }})
                    </label>
                    <label class="flex items-center gap-2 text-white">
                        <input type="radio" name="payment_method" value="visa">
                        Use another Visa card
                    </label>
                @else
                    <label class="flex items-center gap-2 text-white">
                        <input type="radio" name="payment_method" value="visa" checked>
                        Visa
                    </label>
                @endif

                <label class="flex items-center gap-2 text-white">
                    <input type="radio" name="payment_method" value="paypal">
                    PayPal
                </label>
                <label class="flex items-center gap-2 text-white">
                    <input type="radio" name="payment_method" value="mbway">
                    MB WAY
                </label>
            </div>

            <div id="visa-fields" class="mt-2 hidden">
                <label for="visa_number" class="block mt-2 text-white">Visa Card Number</label>
                <input type="text" name="visa_number" id="visa_number" class="w-full rounded bg-zinc-800 border border-zinc-700 text-white px-3 py-2" maxlength="16" pattern="\d{16}" placeholder="1234 5678 9012 3456">
                <label for="visa_cvc" class="block mt-2 text-white">CVC</label>
                <input type="text" name="visa_cvc" id="visa_cvc" class="w-full rounded bg-zinc-800 border border-zinc-700 text-white px-3 py-2" maxlength="3" pattern="\d{3}" placeholder="123">
            </div>

            <div id="paypal-fields" class="mt-2 hidden">
                <label for="paypal_email" class="block mt-2 text-white">PayPal Email</label>
                <input type="email" name="paypal_email" id="paypal_email" class="w-full rounded bg-zinc-800 border border-zinc-700 text-white px-3 py-2" placeholder="your@email.com">
            </div>

            <div id="mbway-fields" class="mt-2 hidden">
                <label for="mbway_phone" class="block mt-2 text-white">MB WAY Phone</label>
                <input type="text" name="mbway_phone" id="mbway_phone" class="w-full rounded bg-zinc-800 border border-zinc-700 text-white px-3 py-2" pattern="9\d{8}" maxlength="9" placeholder="9XXXXXXXX">
            </div>
        </div>

        <div class="flex gap-4 mt-6">
            <button type="submit" class="px-6 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">Create Order</button>
            <a href="{{ route('cart.show') }}" class="px-6 py-2 rounded bg-zinc-700 text-white hover:bg-zinc-600">Back to Cart</a>
        </div>
    </form>
</x-layouts.main-content>

<script>
    function updatePaymentFields() {
        const method = document.querySelector('input[name="payment_method"]:checked').value;
        document.getElementById('visa-fields').classList.toggle('hidden', method !== 'visa');
        document.getElementById('paypal-fields').classList.toggle('hidden', method !== 'paypal');
        document.getElementById('mbway-fields').classList.toggle('hidden', method !== 'mbway');
    }
    document.querySelectorAll('input[name="payment_method"]').forEach(function(el) {
        el.addEventListener('change', updatePaymentFields);
    });
    updatePaymentFields();
</script>
