<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>
           

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Platform')" class="grid">
                    <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                    <flux:navlist.item icon="folder" :href="route('waste_categories.index')" :current="request()->routeIs('waste_categories.*')" wire:navigate>{{ __('Waste Categories') }}</flux:navlist.item>
                    <flux:navlist.item icon="trash" :href="route('wastes.index')" :current="request()->routeIs('wastes.*')" wire:navigate>{{ __('Wastes') }}</flux:navlist.item>
                </flux:navlist.group>
                <flux:navlist.group :heading="__('Management')" class="grid">
                    <flux:navlist.item icon="cube" :current="request()->routeIs('products.*', 'donations.*', 'orders.*', 'reservations.*')">
                        <div class="flex items-center w-full">
                            <span class="flex-1" onclick="window.location.href='{{ route('products.index') }}'">{{ __('Products') }}</span>
                            <x-heroicon-o-chevron-down class="h-3 w-3 ml-auto transition-transform cursor-pointer" id="products-chevron" onclick="event.stopPropagation(); toggleSubMenu('products-submenu')" />
                        </div>
                    </flux:navlist.item>
                    <div id="products-submenu" class="pl-4 space-y-1 {{ request()->routeIs('donations.*', 'orders.*', 'reservations.*') ? 'block' : 'hidden' }}">
                        <flux:navlist.item icon="gift" :href="route('donations.index')" :current="request()->routeIs('donations.*')" wire:navigate class="text-gray-600 dark:text-gray-300 hover:bg-green-400 dark:hover:bg-green-600 hover:text-white dark:hover:text-white" style="{{ request()->routeIs('donations.*') ? 'background-color: #34D399;' : '' }}">
                            {{ __('Donations') }}
                        </flux:navlist.item>
                        <flux:navlist.item icon="shopping-cart" :href="route('orders.index')" :current="request()->routeIs('orders.*')" wire:navigate class="text-gray-600 dark:text-gray-300 hover:bg-green-400 dark:hover:bg-green-600 hover:text-white dark:hover:text-white" style="{{ request()->routeIs('orders.*') ? 'background-color: #34D399;' : '' }}">
                            {{ __('Orders') }}
                        </flux:navlist.item>
                        <flux:navlist.item icon="calendar" :href="route('reservations.index')" :current="request()->routeIs('reservations.*')" wire:navigate class="text-gray-600 dark:text-gray-300 hover:bg-green-400 dark:hover:bg-green-600 hover:text-white dark:hover:text-white" style="{{ request()->routeIs('reservations.*') ? 'background-color: #34D399;' : '' }}">
                            {{ __('Reservations') }}
                        </flux:navlist.item>
                    </div>
                </flux:navlist.group>

                <flux:navlist.group :heading="__('Management')" class="grid">
                    <flux:navlist.item icon="gift" :href="route('admin.donations.index')" :current="request()->routeIs('admin.donations.*')" wire:navigate class="text-gray-600 dark:text-gray-300 hover:bg-green-400 dark:hover:bg-green-600 hover:text-white dark:hover:text-white" style="{{ request()->routeIs('admin.donations.*') ? 'background-color: #34D399;' : '' }}">
                        {{ __('Donations') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="shopping-cart" :href="route('admin.orders.index')" :current="request()->routeIs('admin.orders.*')" wire:navigate class="text-gray-600 dark:text-gray-300 hover:bg-green-400 dark:hover:bg-green-600 hover:text-white dark:hover:text-white" style="{{ request()->routeIs('admin.orders.*') ? 'background-color: #34D399;' : '' }}">
                        {{ __('Orders') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="calendar" :href="route('admin.reservations.index')" :current="request()->routeIs('admin.reservations.*')" wire:navigate class="text-gray-600 dark:text-gray-300 hover:bg-green-400 dark:hover:bg-green-600 hover:text-white dark:hover:text-white" style="{{ request()->routeIs('admin.reservations.*') ? 'background-color: #34D399;' : '' }}">
                        {{ __('Reservations') }}
                    </flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

            <flux:navlist variant="outline">
                <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                    {{ __('Repository') }}
                </flux:navlist.item>
                <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire" target="_blank">
                    {{ __('Documentation') }}
                </flux:navlist.item>
            </flux:navlist>

            <!-- Desktop User Menu -->
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                />
                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>
                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>
                    <flux:menu.separator />
                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
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
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
            <flux:spacer />
            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
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
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>
                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>
                    <flux:menu.separator />
                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
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
        </flux:header>

        <flux:main>
            {{ $slot }}
        </flux:main>

        @fluxScripts
    </body>
</html>

<script>
    function toggleSubMenu(submenuId) {
        const submenu = document.getElementById(submenuId);
        const chevron = document.getElementById(submenuId.replace('submenu', 'chevron'));
        submenu.classList.toggle('hidden');
        chevron.classList.toggle('rotate-180');
    }
</script>
