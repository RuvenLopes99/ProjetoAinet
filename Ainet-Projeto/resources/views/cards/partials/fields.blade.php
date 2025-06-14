{{-- resources/views/cards/partials/fields.blade.php --}}
@php
    $card = $card ?? new \App\Models\Card();
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp

<div class="flex flex-wrap space-x-8">
    <div class="grow mt-6 space-y-4">
        <flux:input
            name="id"
            label="Card ID"
            :value="old('id', $card->id)"
            :disabled="$readonly || $mode == 'edit'"
        />

        <flux:input
            name="card_number"
            label="Card Number"
            :value="old('card_number', $card->card_number)"
            :disabled="$readonly"
        />

        <flux:input
            name="balance"
            label="Balance"
            type="number"
            step="0.01"
            :value="old('balance', $card->balance)"
            :disabled="$readonly"
        />
    </div>
</div>
