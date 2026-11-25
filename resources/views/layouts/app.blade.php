<!DOCTYPE html>
<html lang="id" class="min-h-screen">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Case 3 DKP</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
    <style>[x-cloak]{display:none !important}</style>
</head>
<body class="min-h-screen bg-zinc-50 dark:bg-zinc-950 text-zinc-800 dark:text-zinc-100 antialiased">

<header class="sticky top-0 z-40 border-b border-zinc-200 dark:border-zinc-800 bg-white/85 dark:bg-zinc-900/85 backdrop-blur">
    <div
        class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8"
        x-data="{ menuOpen: false, userOpen: false }"
        @click.outside="menuOpen = false; userOpen = false"
        @keydown.escape.window="menuOpen = false; userOpen = false"
    >
        <div class="flex h-16 items-center justify-between gap-3">

            {{-- Brand --}}
            <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-2.5 shrink-0">
                <span class="grid size-8 place-items-center rounded-lg bg-zinc-900 dark:bg-white text-white dark:text-zinc-900">
                    <flux:icon name="rocket-launch" class="size-4" />
                </span>
                <span class="text-lg font-semibold tracking-tight">List Tugas</span>
            </a>

            {{-- Menu desktop --}}
            <nav class="hidden sm:flex items-center gap-1">
                <a
                    href="{{ route('dashboard') }}"
                    wire:navigate
                    {{ request()->routeIs('dashboard') ? 'aria-current="page"' : '' }}
                    class="rounded-lg px-3 py-2 text-sm font-medium transition-colors duration-150
                        {{ request()->routeIs('dashboard')
                            ? 'bg-zinc-900 text-white dark:bg-white dark:text-zinc-900'
                            : 'text-zinc-600 hover:bg-zinc-100 hover:text-zinc-900 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-white' }}"
                >Dashboard</a>
                <a
                    href="{{ route('tasks') }}"
                    wire:navigate
                    {{ request()->routeIs('tasks') ? 'aria-current="page"' : '' }}
                    class="rounded-lg px-3 py-2 text-sm font-medium transition-colors duration-150
                        {{ request()->routeIs('tasks')
                            ? 'bg-zinc-900 text-white dark:bg-white dark:text-zinc-900'
                            : 'text-zinc-600 hover:bg-zinc-100 hover:text-zinc-900 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-white' }}"
                >Tugas</a>
            </nav>

            {{-- Sisi kanan: dark mode, dropdown user (desktop), hamburger (mobile) --}}
            <div class="flex items-center gap-1.5">

                {{-- Toggle dark mode (Flux appearance) --}}
                <flux:button
                    variant="ghost"
                    square
                    x-data="{ dark: $flux.appearance === 'dark' }"
                    x-on:click="$flux.appearance = dark ? 'light' : 'dark'; dark = $flux.appearance"
                    aria-label="Ganti mode terang/gelap"
                >
                    <flux:icon x-show="!dark" name="moon" class="size-4" />
                    <flux:icon x-show="dark" name="sun" class="size-4" x-cloak />
                </flux:button>

                {{-- Dropdown user — Alpine (desktop) --}}
                <div class="relative hidden sm:block">
                    <flux:button
                        variant="ghost"
                        x-on:click="userOpen = !userOpen"
                        x-bind:aria-expanded="userOpen ? 'true' : 'false'"
                        aria-haspopup="menu"
                        class="max-w-44"
                    >
                        <flux:icon name="user-circle" class="size-4" />
                        <span class="truncate">{{ auth()->user()->name ?? 'Pengguna' }}</span>
                        <flux:icon name="chevron-down" class="size-3.5 opacity-60" />
                    </flux:button>

                    <div
                        x-show="userOpen"
                        x-cloak
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-52 origin-top-right rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 shadow-lg shadow-zinc-900/10 dark:shadow-black/40 p-1.5"
                        role="menu"
                    >
                        <div class="px-3 py-2 border-b border-zinc-100 dark:border-zinc-700 mb-1">
                            <p class="text-sm font-semibold truncate">{{ auth()->user()->name ?? 'Pengguna' }}</p>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 truncate">{{ auth()->user()->email ?? '' }}</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button
                                type="submit"
                                class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-zinc-600 hover:bg-zinc-100 hover:text-zinc-900 dark:text-zinc-300 dark:hover:bg-zinc-700 dark:hover:text-white transition-colors duration-150"
                                role="menuitem"
                            >
                                <flux:icon name="arrow-left-start-on-rectangle" class="size-4" />
                                Logout
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Hamburger mobile --}}
                <flux:button
                    variant="ghost"
                    square
                    class="sm:hidden"
                    x-on:click="menuOpen = !menuOpen"
                    x-bind:aria-expanded="menuOpen ? 'true' : 'false'"
                    aria-label="Buka menu"
                >
                    <flux:icon x-show="!menuOpen" name="bars-3" class="size-5" />
                    <flux:icon x-show="menuOpen" name="x-mark" class="size-5" x-cloak />
                </flux:button>
            </div>
        </div>

        {{-- Menu mobile — Alpine --}}
        <div
            x-show="menuOpen"
            x-cloak
            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 -translate-y-1"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-1"
            class="sm:hidden border-t border-zinc-200 dark:border-zinc-800 py-3 space-y-1"
        >
            <a
                href="{{ route('dashboard') }}"
                wire:navigate
                x-on:click="menuOpen = false"
                class="block rounded-lg px-3 py-2 text-sm font-medium
                    {{ request()->routeIs('dashboard')
                        ? 'bg-zinc-900 text-white dark:bg-white dark:text-zinc-900'
                        : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:bg-zinc-800' }}"
            >Dashboard</a>
            <a
                href="{{ route('tasks') }}"
                wire:navigate
                x-on:click="menuOpen = false"
                class="block rounded-lg px-3 py-2 text-sm font-medium
                    {{ request()->routeIs('tasks')
                        ? 'bg-zinc-900 text-white dark:bg-white dark:text-zinc-900'
                        : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:bg-zinc-800' }}"
            >Tugas</a>

            <div class="pt-2 mt-2 border-t border-zinc-100 dark:border-zinc-800">
                <p class="px-3 text-xs text-zinc-500 dark:text-zinc-400 truncate">{{ auth()->user()->name ?? 'Pengguna' }}</p>
                <form method="POST" action="{{ route('logout') }}" class="mt-1">
                    @csrf
                    <button
                        type="submit"
                        class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-zinc-600 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800 transition-colors duration-150"
                    >
                        <flux:icon name="arrow-left-start-on-rectangle" class="size-4" />
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

<main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10 pb-20">
    {{ $slot }}
</main>

@fluxScripts
</body>
</html>
