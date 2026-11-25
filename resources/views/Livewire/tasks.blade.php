<div class="space-y-4">
    <div class="flex flex-col sm:flex-row gap-2 sm:items-center sm:justify-between">
        <flux:heading size="xl">{{ $showTrash ? 'Tempat Sampah' : 'Daftar Tugas' }}</flux:heading>
        <div class="flex gap-2">
            <flux:button wire:click="$toggle('showTrash')">
                {{ $showTrash ? 'Kembali' : 'Sampah' }}
            </flux:button>
            @unless ($showTrash)
                <flux:button variant="primary" wire:click="create">+ Tugas</flux:button>
            @endunless
        </div>
    </div>

    <flux:input wire:model.live.debounce.300ms="search" placeholder="Cari tugas..." />

    <div class="grid gap-3 md:grid-cols-2">
        @forelse ($tasks as $task)
            <div wire:key="task-{{ $task->id }}" class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg p-4 space-y-2">
                <div class="flex items-start justify-between gap-2">
                    <div class="font-medium">{{ $task->title }}</div>
                    <flux:badge size="sm" color="{{ $task->status === 'selesai' ? 'green' : 'amber' }}">{{ $task->status }}</flux:badge>
                </div>
                <div class="text-sm text-zinc-500">{{ $task->description }}</div>
                <div class="text-xs text-zinc-500">
                    Prioritas: {{ $task->priority }} · Deadline: {{ $task->deadline?->format('d M Y') ?? '-' }}
                </div>
                <div class="flex gap-2 pt-1">
                    @if ($showTrash)
                        <flux:button size="sm" wire:click="restore({{ $task->id }})">Pulihkan</flux:button>
                        <flux:button size="sm" variant="danger" wire:click="forceDelete({{ $task->id }})" wire:confirm="Hapus permanen?">Hapus Permanen</flux:button>
                    @else
                        <flux:button size="sm" wire:click="edit({{ $task->id }})">Edit</flux:button>
                        <flux:button size="sm" variant="danger" wire:click="delete({{ $task->id }})" wire:confirm="Pindahkan ke sampah?">Hapus</flux:button>
                    @endif
                </div>
            </div>
        @empty
            <flux:text>Tidak ada data.</flux:text>
        @endforelse
    </div>

    {{-- Modal form dengan Alpine.js --}}
    <div x-data x-show="$wire.showForm" x-transition.opacity x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
         @keydown.escape.window="$wire.showForm = false">
        <div @click.outside="$wire.showForm = false"
             class="w-full max-w-md bg-white dark:bg-zinc-800 rounded-lg p-5 space-y-4">
            <flux:heading size="lg">{{ $taskId ? 'Edit Tugas' : 'Tugas Baru' }}</flux:heading>
            <form wire:submit="save" class="space-y-3">
                <flux:input label="Judul" wire:model="title" />
                <flux:textarea label="Deskripsi" wire:model="description" />
                <flux:select label="Prioritas" wire:model="priority">
                    <flux:select.option value="rendah">Rendah</flux:select.option>
                    <flux:select.option value="sedang">Sedang</flux:select.option>
                    <flux:select.option value="tinggi">Tinggi</flux:select.option>
                </flux:select>
                <flux:select label="Status" wire:model="status">
                    <flux:select.option value="pending">Pending</flux:select.option>
                    <flux:select.option value="selesai">Selesai</flux:select.option>
                </flux:select>
                <flux:input label="Deadline" type="date" wire:model="deadline" />
                <div class="flex gap-2 justify-end">
                    <flux:button type="button" @click="$wire.showForm = false">Batal</flux:button>
                    <flux:button type="submit" variant="primary">Simpan</flux:button>
                </div>
            </form>
        </div>
    </div>
</div>