<div class="space-y-8">

    {{-- Kepala halaman --}}
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <flux:heading level="1" size="xl">Dashboard</flux:heading>
            <flux:text class="mt-1">
                Halo, {{ auth()->user()->name }} ayo masukkan tugas kamu.
            </flux:text>
        </div>

        <flux:button href="{{ route('tasks') }}" variant="primary" icon-trailing="arrow-right" wire:navigate>
            Buka Tugas
        </flux:button>
    </div>

    @php($total = (int) $stats['total'])
    @php($selesai = (int) $stats['selesai'])
    @php($pending = (int) $stats['pending'])
    @php($persenSelesai = $total > 0 ? (int) round($selesai / $total * 100) : 0)

    {{-- Kartu statistik --}}
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">

        {{-- Total --}}
        <flux:card>
            <div class="flex items-start justify-between">
                <span class="grid size-10 place-items-center rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300">
                    <flux:icon name="squares-2x2" class="size-5" />
                </span>
                <flux:badge color="zinc" variant="pill" size="sm">Semua</flux:badge>
            </div>
            <flux:heading level="2" size="xl" class="mt-4 tabular-nums">{{ $total }}</flux:heading>
            <flux:text>Total tugas</flux:text>
        </flux:card>

        {{-- Selesai --}}
        <flux:card>
            <div class="flex items-start justify-between">
                <span class="grid size-10 place-items-center rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-600 dark:text-emerald-400">
                    <flux:icon name="check-circle" class="size-5" />
                </span>
                <flux:badge color="green" variant="pill" size="sm">{{ $persenSelesai }}%</flux:badge>
            </div>
            <flux:heading level="2" size="xl" class="mt-4 tabular-nums">{{ $selesai }}</flux:heading>
            <flux:text>Tugas selesai</flux:text>
        </flux:card>

        {{-- Pending --}}
        <flux:card class="sm:col-span-2 lg:col-span-1">
            <div class="flex items-start justify-between">
                <span class="grid size-10 place-items-center rounded-full bg-amber-100 dark:bg-amber-950 text-amber-600 dark:text-amber-400">
                    <flux:icon name="clock" class="size-5" />
                </span>
                <flux:badge color="amber" variant="pill" size="sm">Menunggu</flux:badge>
            </div>
            <flux:heading level="2" size="xl" class="mt-4 tabular-nums">{{ $pending }}</flux:heading>
            <flux:text>Tugas pending</flux:text>
        </flux:card>
    </div>

    {{-- Keadaan kosong --}}
    @if ($total === 0)
        <flux:card class="text-center">
            <div class="py-10">
                <span class="mx-auto grid size-12 place-items-center rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-400">
                    <flux:icon name="inbox" class="size-6" />
                </span>
                <flux:heading level="3" class="mt-3">Belum ada tugas</flux:heading>
                <flux:text class="mt-1">Mulai dengan membuat tugas pertamamu di halaman Tugas.</flux:text>
                <div class="mt-4">
                    <flux:button href="{{ route('tasks') }}" variant="primary" icon-trailing="arrow-right" wire:navigate>
                        Buka halaman Tugas
                    </flux:button>
                </div>
            </div>
        </flux:card>
    @endif

    {{-- Keterangan sumber data --}}
    <flux:text size="sm" class="flex items-center gap-1.5">
        <flux:icon name="circle-stack" class="size-3.5 shrink-0" />
        Statistik dari cache · dihitung {{ $stats['dihitung'] }}
    </flux:text>
</div>
