<?php

namespace App\Livewire;

use App\Models\Task;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Tasks extends Component
{
    public $search = '';
    public $showTrash = false;
    public $showForm = false;
    public $taskId = null;
    public $title = '';
    public $description = '';
    public $priority = 'sedang';
    public $status = 'pending';
    public $deadline = '';

    public function create()
    {
        $this->reset(['taskId', 'title', 'description', 'priority', 'status', 'deadline']);
        $this->resetValidation();
        $this->showForm = true;
    }

    public function edit($id)
    {
        $t = Task::where('user_id', auth()->id())->findOrFail($id);
        $this->taskId = $t->id;
        $this->title = $t->title;
        $this->description = $t->description;
        $this->priority = $t->priority;
        $this->status = $t->status;
        $this->deadline = $t->deadline?->format('Y-m-d');
        $this->showForm = true;
    }

    public function save()
    {
        $data = $this->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'priority' => 'required|in:rendah,sedang,tinggi',
            'status' => 'required|in:pending,selesai',
            'deadline' => 'nullable|date',
        ]);
        $data['deadline'] = $data['deadline'] ?: null;

        Task::updateOrCreate(
            ['id' => $this->taskId, 'user_id' => auth()->id()],
            $data
        );

        $this->showForm = false;
        $this->clearStats();
    }

    public function delete($id)
    {
        Task::where('user_id', auth()->id())->findOrFail($id)->delete();
        $this->clearStats();
    }

    public function restore($id)
    {
        Task::onlyTrashed()->where('user_id', auth()->id())->findOrFail($id)->restore();
        $this->clearStats();
    }

    public function forceDelete($id)
    {
        Task::onlyTrashed()->where('user_id', auth()->id())->findOrFail($id)->forceDelete();
        $this->clearStats();
    }

    private function clearStats()
    {
        Cache::forget('stats.user.' . auth()->id());
    }

    public function render()
    {
        $query = Task::where('user_id', auth()->id())
            ->where('title', 'like', '%' . $this->search . '%');

        if ($this->showTrash) {
            $query->onlyTrashed();
        }

        return view('livewire.tasks', ['tasks' => $query->latest()->get()]);
    }
}