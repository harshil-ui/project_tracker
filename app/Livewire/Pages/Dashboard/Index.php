<?php

namespace App\Livewire\Pages\Dashboard;

use App\Models\Project;
use App\Models\Task;
use Livewire\Component;

class Index extends Component
{
    public $totalProjects, $pendingTasks, $overDueTasks, $completedTasks;

    public function boot()
    {
        $this->totalProjects = Project::count();
        $this->pendingTasks = Task::where('status', '!=', 'done')->count();
        $this->completedTasks = Task::where('status', 'done')->count();
        $this->overDueTasks = Task::where('due_date', '<', date('Y-m-d'))
            ->where('status', '!=', 'done')->count();
    }

    public function render()
    {
        return view('livewire.pages.dashboard.index');
    }
}
