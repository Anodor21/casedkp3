<?php

namespace App\Jobs;

use App\Models\Task;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class PurgeOldTrashedTasks implements ShouldQueue
{
    use Queueable;

    public function handle(): void
    {
        Task::onlyTrashed()
            ->where('deleted_at', '<', now()->subDays(30))
            ->forceDelete();
    }
}