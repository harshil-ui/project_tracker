<?php

namespace App\Livewire\Pages\Project;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $project_id = null;
    public $title;
    public $description;
    public $showModal = false;

    protected $rules = [
        'title' => 'required|string',
        'description' => 'required|string',
    ];

    protected $paginationTheme = 'tailwind';

    public function render()
    {
        $projects = Project::select('id', 'title', 'description')->latest()
            ->paginate(10);

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
