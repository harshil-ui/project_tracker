<?php

namespace App\Livewire\Pages\Project;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $project_id = null;
    public $title;
    public $description;
    public $showModal = false;
    public $user = null;

    protected $rules = [
        'title' => 'required|string',
        'description' => 'required|string',
    ];

    protected $paginationTheme = 'tailwind';

    public function boot()
    {
        $this->user = Auth::user();
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function render()
    {
        $projects = Project::select('id', 'title', 'description')->latest()
            ->paginate(5)->onEachSide(0);

        return view('livewire.pages.project.index', compact('projects'));
    }

    public function save()
    {
        $this->validate();

        if (empty($this->project_id)) {

            Project::create([
                'title' => $this->title,
                'description' => $this->description,
            ]);

            session()->flash('message', "Project Named {$this->title} created successfully!");
        } else {
            $project = Project::find($this->project_id);
            $project->update([
                'title' => $this->title,
                'description' => $this->description,
            ]);

            session()->flash('message', "Project Named {$this->title} updated successfully!");
        }

        $this->reset(['title', 'description', 'project_id']);

        $this->showModal = false;

        return $this->redirect(route('projects.index'), navigate: true);
    }

    public function delete($id)
    {
        $project = Project::with('tasks')->find($id);

        if ($project->tasks->count() > 0) {
            session()->flash('error', "This Project cannot be deleted because it has associated tasks.");
            return $this->redirect(route('projects.index'), navigate: true);
        }

        Project::find($id)->delete();
        session()->flash('message', "Project deleted successfully!");
        return $this->redirect(route('projects.index'), navigate: true);
    }

    public function edit($id)
    {
        $project = Project::find($id);
        $this->project_id = $project->id;
        $this->title = $project->title;
        $this->description = $project->description;
        $this->showModal = true;
    }

    public function resetInput()
    {
        $this->reset(['title', 'description', 'project_id']);
    }
}
