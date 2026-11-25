<div class="space-y-6">
    <flux:heading size="xl">Masuk</flux:heading>

    <form wire:submit="login" class="space-y-4">
        <flux:input label="Email" type="email" wire:model="email" />
        <flux:input label="Password" type="password" wire:model="password" />
        <flux:button type="submit" variant="primary" class="w-full">Masuk</flux:button>
    </form>

    <flux:text>Belum punya akun?
        <a href="{{ route('register') }}" class="underline">Daftar</a>
    </flux:text>
</div>