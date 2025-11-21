<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskComponent extends Component
{
    public $tasks;
    public $taskId;
    public $title;
    public $description;
    public $modal = false;

    public function mount()
    {
        $this->tasks = $this->getTask();
    }

    public function getTask()
    {
        return Task::where('user_id', Auth::id())->orderBy('title','asc')->get();
    }

    public function render()
    {
        return view('livewire.task-component');
    }

    private function clearFields()
    {
        $this->taskId = null;
        $this->title = '';
        $this->description = '';
    }

    public function openCreateModal()
    {
        $this->clearFields();
        $this->modal = true;
    }

    public function openEditModal(Task $task)
    {
        $this->taskId = $task->id;
        $this->title = $task->title;
        $this->description = $task->description;
        $this->modal = true;
    }

    public function closeCreateModal()
    {
        $this->modal = false;
    }

public function createOrUpdateTask()
{
    // validar
    $this->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    if ($this->taskId) {
        // actualizar
        $task = Task::find($this->taskId);
        $task->update([
            'title' => $this->title,
            'description' => $this->description,
        ]);
    } else {
        // crear
        Task::create([
            'title' => $this->title,
            'description' => $this->description,
            'user_id' => Auth::id(),
        ]);
    }

    $this->clearFields();
    $this->modal = false;
    $this->tasks = $this->getTask()->sortBy('title');
}

    public function deleteTask(Task $task)
    {
        $task->delete();
        $tasks = $this->getTask()->sortBy('id');
    }
}
