<x-layouts.app.sidebar>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Perfil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    {{-- Formulário de atualização de perfil --}}
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                Informação do Perfil
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                Atualize a informação do seu perfil e o seu endereço de email.
                            </p>
                        </header>

                        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('patch')

                            {{-- NOME --}}
                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name"
                                    @cannot('update', $user) disabled @endcannot />
                            </div>

                            {{-- EMAIL --}}
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username"
                                     @cannot('update', $user) disabled @endcannot />
                            </div>

                            {{-- NIF (Apenas para Membros e Conselho) --}}
                            @if ($user->type === \App\Enums\UserType::MEMBER || $user->type === \App\Enums\UserType::BOARD)
                                <div>
                                    <x-input-label for="nif" :value="__('NIF')" />
                                    <x-text-input id="nif" name="nif" type="text" class="mt-1 block w-full" :value="old('nif', $user->nif)" />
                                </div>
                            @endif

                            {{-- Apenas o utilizador pode guardar as suas alterações --}}
                            @can('update', $user)
                                <div class="flex items-center gap-4">
                                    <x-primary-button>{{ __('Guardar') }}</x-primary-button>
                                    @if (session('status') === 'profile-updated')
                                        <p class="text-sm text-gray-600">{{ __('Guardado.') }}</p>
                                    @endif
                                </div>
                            @else
                                <p class="text-sm text-red-600 mt-2">Os seus dados só podem ser alterados por um administrador.</p>
                            @endcan
                        </form>
                    </section>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    {{-- Formulário para atualizar password --}}
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>
</x-layouts.app.sidebar>
