<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskComponent extends Component
{
    public $tasks = [];
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
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Unimos tareas propias + compartidas
        return $user->ownTasks()
            ->orderBy('title')
            ->get()
            ->merge(
                $user->sharedTasks()->orderBy('title')->get()
            );
    }

    public function render()
    {
        // return view('livewire.task-component');

        // dd(Auth::id());
        /*
        return view('livewire.task-component', [
            'tasks' => Task::where('user_id', Auth::id())->orderBy('title')->get()
        ]);
        */
        return view('livewire.task-component', [
            'tasks' => $this->tasks
        ]);
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

    public function openEditModal($id)
    {
        /*
        $task = Task::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $this->taskId = $task->id;
        $this->title = $task->title;
        $this->description = $task->description;
        $this->modal = true;
        */
        /** @var \App\Models\User $user */
        $user = Auth::user(); // Docblock ayuda a IntelliSense
        $task = $user->tasks()->where('tasks.id', $id)->firstOrFail();
        // $task = Auth::user()->tasks()->where('tasks.id', $id)->firstOrFail();

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

    public function deleteTask($taskId)
    {
        Task::where('id', $taskId)->where('user_id', Auth::id())->delete();
        $this->tasks = $this->getTask();
    }
}
