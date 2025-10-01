<?php

namespace App\Livewire\Pages\Task;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    
    public $task_id = null, $name, $description, $status, $due_date, $priority, $project_id;
    public $showModal = false;
    public $projects;
    protected $paginationTheme = 'tailwind';
    public $user = null;

    protected $rules = [
        'name' => 'required|string',
        'description' => 'required|string',
        'status' => 'required|string',
        'due_date' => 'required|date',
        'priority' => 'required|string',
        'project_id' => 'required'
    ];

    protected $messages = [
        'name' => 'Please enter task name',
        'description' => 'Please enter task description',
        'status' => 'Please select task status',
        'due_date' => 'Please select due date',
        'priority' => 'Please select task priority',
        'project_id' => 'Please select project'
    ];


    public function boot()
    {
        $this->user = Auth::user();

        $this->projects = Project::select('id', 'title')->get();
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function render()
    {
        $tasks = Task::with('project')->latest()->paginate(5)->onEachSide(0);

        return view('livewire.pages.task.index', compact('tasks'));
    }

    public function save()
    {
        $this->validate();

        if (empty($this->task_id)) {
            Task::Create($this->validate());
            session()->flash('message', "Task Named {$this->name} created successfully!");
        } else {
            $task = Task::find($this->task_id);
            $task->update($this->validate());
            session()->flash('message', "Task Named {$this->name} updated successfully!");
        }

        $this->resetInput();

        $this->showModal = false;

        return $this->redirect(route('tasks.index'), navigate: true);
    }

    public function edit($id)
    {
        $task = Task::find($id);
        $this->task_id = $task->id;
        $this->name = $task->name;
        $this->description = $task->description;
        $this->status = $task->status;
        $this->due_date = $task->due_date;
        $this->priority = $task->priority;
        $this->project_id = $task->project_id;

        $this->showModal = true;
    }

    public function delete($id)
    {
        Task::find($id)->delete();
        session()->flash('message', "Task deleted successfully!");
        return $this->redirect(route('tasks.index'), navigate: true);
    }

    public function resetInput()
    {
        $this->reset([
            'name',
            'description',
            'status',
            'due_date',
            'priority',
            'project_id',
            'task_id'
        ]);
    }
}
