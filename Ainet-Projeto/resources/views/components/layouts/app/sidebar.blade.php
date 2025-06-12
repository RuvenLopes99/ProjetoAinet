<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

{{--            <a href="{{ route('home') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>--}}
            <a href="{{ route('home') }}" class="mb-0" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="'Management'" class="grid">
                    <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>


            {{-- <flux:spacer /> --}}

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="'Pages'" class="grid">
                    <flux:navlist.item icon="cube" :href="route('products.showcase')" :current="request()->routeIs('products.showcase')" wire:navigate>Products</flux:navlist.item>
                    <flux:navlist.item icon="shopping-cart" :href="route('cart.show')" :current="request()->routeIs('cart.show')" wire:navigate>My Cart</flux:navlist.item>
                    <flux:navlist.item icon="list-bullet" :href="route('orders.myOrders')" :current="request()->routeIs('orders.myOrders')" wire:navigate>My Orders</flux:navlist.item>
               </flux:navlist.group>
            </flux:navlist>

            {{-- Admin Sections --}}
            @auth
                @if(auth()->user()->type === 'admin')
                    <section class="mt-4">
                        <h3 class="px-4 py-2 text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400">
                            Admin
                        </h3>
                        <flux:navlist variant="outline" heading="Admin Sections" class="grid">
                            <flux:navlist.group :heading="'Inventory'" class="grid">
                                <flux:navlist.item icon="cube" :href="route('products.index')" :current="request()->routeIs('products.index')" wire:navigate>Products</flux:navlist.item>
                                <flux:navlist.item icon="shopping-cart" :href="route('orders.index')" :current="request()->routeIs('orders.index')" :current="false" wire:navigate>Orders</flux:navlist.item>
                                <flux:navlist.item icon="list-bullet" :href="route('itemsOrders.index')" :current="request()->routeIs('itemsOrders.index')" :current="false" wire:navigate>Item Orders</flux:navlist.item>
                                <flux:navlist.item icon="adjustments-horizontal" :href="route('stockAdjustments.index')" :current="request()->routeIs('stockAdjustments.index')" :current="false" wire:navigate>Stock Adjustments</flux:navlist.item>
                                <flux:navlist.item icon="truck" :href="route('supplyOrders.index')" :current="request()->routeIs('supplyOrders.index')" :current="false" wire:navigate>Supply Orders</flux:navlist.item>
                            </flux:navlist.group>
                        </flux:navlist>

                        <flux:navlist variant="outline">
                            <flux:navlist.group :heading="'Users'" class="grid">
                                <flux:navlist.item icon="users" icon:variant="solid" :href="route('users.index')" :current="request()->routeIs('users.index')" :current="false" wire:navigate>Users</flux:navlist.item>
                                <flux:navlist.item icon="credit-card" icon:variant="solid" :href="route('cards.index')" :current="request()->routeIs('cards.index')" :current="false" wire:navigate>Cards</flux:navlist.item>
                            </flux:navlist.group>
                        </flux:navlist>

                        <flux:navlist variant="outline">
                            <flux:navlist.group :heading="'Settings'" class="grid">
                                <flux:navlist.item icon="tag" icon:variant="solid" :href="route('categories.index')" :current="request()->routeIs('categories.index')" :current="false" wire:navigate>Categories</flux:navlist.item>
                                <flux:navlist.item icon="wrench-screwdriver" icon:variant="solid" :href="route('operations.index')" :current="request()->routeIs('operations.index')" :current="false" wire:navigate>Operations</flux:navlist.item>
                                <flux:navlist.item icon="cog" icon:variant="solid" :href="route('settings.index')" :current="request()->routeIs('settings.index')" :current="false" wire:navigate>Settings</flux:navlist.item>
                                <flux:navlist.item icon="truck" icon:variant="solid" :href="route('settingsShippingCosts.index')" :current="request()->routeIs('settingsShippingCosts.index')" :current="false" wire:navigate>Settings of Shipping Costs</flux:navlist.item>
                            </flux:navlist.group>
                        </flux:navlist>
                    </section>
                @endif
            @endauth

            <flux:spacer/>

            <!-- Desktop User Menu -->
            @auth
                <flux:dropdown position="bottom" align="start">
                    <flux:profile
                        :name="auth()->user()?->firstLastName()"
                        :initials="auth()->user()?->firstLastInitial()"
                        icon-trailing="chevrons-up-down"
                    />

                    <flux:menu class="w-[220px]">
                        <flux:menu.radio.group>
                            <div class="p-0 text-sm font-normal">
                                <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                    <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                        <span
                                            class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                        >
                                            {{ auth()->user()?->firstLastInitial()}}
                                        </span>
                                    </span>

                                    <div class="grid flex-1 text-start text-sm leading-tight">
                                        <span class="truncate font-semibold">{{ auth()->user()?->name}}</span>
                                        <span class="truncate text-xs">{{ auth()->user()?->email }}</span>
                                    </div>
                                </div>
                            </div>
                        </flux:menu.radio.group>

                        <flux:menu.separator />

                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                                {{ __('Log Out') }}
                            </flux:menu.item>
                        </form>
                    </flux:menu>
                </flux:dropdown>
            @else
                <flux:navlist variant="outline">
                    <flux:navlist.group :heading="'Authentication'" class="grid">
                        <flux:navlist.item icon="key" :href="route('login')" :current="request()->routeIs('login')" wire:navigate>Login</flux:navlist.item>
                    </flux:navlist.group>
                </flux:navlist>
            @endauth
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            @auth
            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()?->firstLastInitial()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()?->firstLastInitial()}}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()?->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()?->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />
                    
                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
            @else
                <flux:navbar>
                    <flux:navbar.item  icon="key" :href="route('login')" :current="request()->routeIs('login')" wire:navigate>Login</flux:navbar.item>
                </flux:navbar>
            @endauth
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
