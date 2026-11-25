<?php

namespace App\Livewire;

use App\Models\Task;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    public function render()
    {
        $userId = auth()->id();

        $stats = Cache::remember("stats.user.{$userId}", 300, function () use ($userId) {
            $q = Task::where('user_id', $userId);

            return [
                'total'   => (clone $q)->count(),
                'selesai' => (clone $q)->where('status', 'selesai')->count(),
                'pending' => (clone $q)->where('status', 'pending')->count(),
                'dihitung' => now()->format('H:i:s'),
            ];
        });

        return view('livewire.dashboard', ['stats' => $stats]);
    }
}