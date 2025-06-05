{{-- resources/views/users/show.blade.php --}}
<x-layouts.main-content :title="'User #'.$user->id"
                        heading="User Details"
                        :subheading="$user->name">
    <div class="flex flex-col space-y-6">
        <div class="max-full">
            <section>
                <div class="flex flex-wrap justify-start items-center gap-4 mb-4">
                    <flux:button variant="primary" href="{{ route('users.edit', ['user' => $user]) }}">Edit</flux:button>
                    <flux:button href="{{ route('users.create') }}">New</flux:button>
                    <form method="POST" action="{{ route('users.destroy', ['user' => $user]) }}">
                        @csrf
                        @method('DELETE')
                        <flux:button variant="danger" type="submit">Delete</flux:button>
                    </form>
                </div>
                <div class="mt-6 space-y-4">
                    <div><strong>User ID:</strong> {{ $user->id }}</div>
                    <div><strong>Name:</strong> {{ $user->name }}</div>
                    <div><strong>Email:</strong> {{ $user->email }}</div>
                    <div><strong>Type:</strong> {{ $user->type }}</div>
                    <div><strong>Blocked:</strong> {{ $user->blocked ? 'Yes' : 'No' }}</div>
                    <div><strong>Gender:</strong> {{ $user->gender }}</div>
                    <div><strong>Photo:</strong> {{ $user->photo }}</div>
                    <div><strong>NIF:</strong> {{ $user->nif }}</div>
                    <div><strong>Default Delivery Address:</strong> {{ $user->default_delivery_address }}</div>
                    <div><strong>Default Payment Type:</strong> {{ $user->default_payment_type }}</div>
                    <div><strong>Default Payment Reference:</strong> {{ $user->default_payment_reference }}</div>
                </div>
            </section>
        </div>
    </div>
</x-layouts.main-content>
