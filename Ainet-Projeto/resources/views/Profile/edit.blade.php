{{--
    Ficheiro: resources/views/profile/edit.blade.php
    Esta é a versão final e corrigida. A estrutura foi alterada para funcionar
    dentro de um layout flex, resolvendo o problema de o conteúdo ficar
    preso no canto inferior da página.
--}}
<x-layouts.app.sidebar>
    {{--
        NOTA DA CORREÇÃO DE LAYOUT:
        Envolvemos o <main> numa div com `flex-1` para que ele ocupe todo
        o espaço vertical disponível. O `overflow-y-auto` adiciona uma barra
        de scroll interna apenas a esta área de conteúdo se for necessário,
        em vez de o conteúdo empurrar a página para baixo.
        O `lg:pl-72` (ou similar, dependendo da largura da sua sidebar)
        garante que o conteúdo não fica por baixo do menu em ecrãs grandes.
    --}}
    <div class="flex flex-1 flex-col overflow-y-auto">
        <main class="flex-1 lg:pl-72"> {{-- Ajuste lg:pl-72 se a sua sidebar tiver outra largura --}}
            <div class="p-4 sm:p-6 lg:p-8">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-100">
                    {{ __('Perfil') }}
                </h2>

                @php
                    $viewerIsAdmin = auth()->user()->type === \App\Enums\UserType::BOARD;
                    $isViewingOwnProfile = auth()->id() === $user->id;
                    $profileIsEmployee = $user->type === \App\Enums\UserType::EMPLOYEE;
                    $canEditDetails = $viewerIsAdmin || ($isViewingOwnProfile && !$profileIsEmployee);
                @endphp

                <div class="mt-8 max-w-7xl space-y-6">

                    {{-- Formulário de atualização de perfil --}}
                    <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-zinc-800/50">
                        <div class="max-w-xl">
                            <section>
                                <header>
                                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                        Informação do Perfil
                                    </h2>
                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                        Atualize a informação do seu perfil e o seu endereço de email.
                                    </p>
                                </header>

                                <form method="post" action="{{ route('profile.update', $user) }}" class="mt-6 space-y-6">
                                    @csrf
                                    @method('patch')

                                    {{-- NOME --}}
                                    <div>
                                        <x-input-label for="name" :value="__('Name')" />
                                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name"
                                                      :disabled="!$canEditDetails" />
                                    </div>

                                    {{-- EMAIL --}}
                                    <div>
                                        <x-input-label for="email" :value="__('Email')" />
                                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username"
                                                      :disabled="!$canEditDetails" />
                                    </div>

                                    {{-- NIF (Apenas para Membros e Conselho) --}}
                                    @if ($user->type === \App\Enums\UserType::MEMBER || $user->type === \App\Enums\UserType::BOARD)
                                        <div>
                                            <x-input-label for="nif" :value="__('NIF')" />
                                            <x-text-input id="nif" name="nif" type="text" class="mt-1 block w-full" :value="old('nif', $user->nif)"
                                                          :disabled="!$canEditDetails" />
                                        </div>
                                    @endif

                                    @if ($canEditDetails)
                                        <div class="flex items-center gap-4">
                                            <x-primary-button>{{ __('Guardar') }}</x-primary-button>
                                            @if (session('status') === 'profile-updated')
                                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Guardado.') }}</p>
                                            @endif
                                        </div>
                                    @else
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">Não tem permissão para alterar estes dados.</p>
                                    @endif
                                </form>
                            </section>
                        </div>
                    </div>

                    {{-- Formulário para atualizar password --}}
                    <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-zinc-800/50">
                        <div class="max-w-xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>
</x-layouts.app.sidebar>
