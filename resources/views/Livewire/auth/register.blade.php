<div class="space-y-6">
    <flux:heading size="xl">Daftar Akun</flux:heading>

    <form wire:submit="register" class="space-y-4">
        <flux:input label="Nama" wire:model="name" />
        <flux:input label="Email" type="email" wire:model="email" />
        <flux:input label="Password" type="password" wire:model="password" />
        <flux:input label="Konfirmasi Password" type="password" wire:model="password_confirmation" />
        <flux:button type="submit" variant="primary" class="w-full">Daftar</flux:button>
    </form>

    <flux:text>Sudah punya akun?
        <a href="{{ route('login') }}" class="underline">Masuk</a>
    </flux:text>
</div>