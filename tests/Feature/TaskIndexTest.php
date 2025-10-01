<?php

use App\Livewire\Pages\Task\Index;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user); // Log in user for auth
    $this->project = Project::factory()->create();
});

// Test rendering the component
it('renders the task index component', function () {
    Livewire::test(Index::class)
        ->assertStatus(200)
        ->assertSee('Tasks'); // Replace with text in your Blade view
});

// Test creating a new task
it('can create a new task', function () {
    Livewire::test(Index::class)
        ->set('name', 'Test Task')
        ->set('description', 'Test Description')
        ->set('status', 'pending')
        ->set('due_date', now()->addDays(5)->format('Y-m-d'))
        ->set('priority', 'high')
        ->set('project_id', $this->project->id)
        ->call('save')
        ->assertRedirect(route('tasks.index'));

    $this->assertDatabaseHas('tasks', [
        'name' => 'Test Task',
        'description' => 'Test Description',
        'status' => 'pending',
        'priority' => 'high',
        'project_id' => $this->project->id,
    ]);
});

// Test editing an existing task
it('can edit an existing task', function () {
    $task = Task::factory()->create([
        'name' => 'Old Task',
        'description' => 'Old Description',
        'status' => 'pending',
        'due_date' => now()->addDays(3)->format('Y-m-d'),
        'priority' => 'medium',
        'project_id' => $this->project->id,
    ]);

    Livewire::test(Index::class)
        ->call('edit', $task->id)
        ->set('name', 'Updated Task')
        ->set('description', 'Updated Description')
        ->call('save')
        ->assertRedirect(route('tasks.index'));

    $this->assertDatabaseHas('tasks', [
        'id' => $task->id,
        'name' => 'Updated Task',
        'description' => 'Updated Description',
    ]);
});

// Test deleting a task
it('can delete a task', function () {
    $task = Task::factory()->create([
        'project_id' => $this->project->id,
    ]);

    Livewire::test(Index::class)
        ->call('delete', $task->id)
        ->assertRedirect(route('tasks.index'));

    $this->assertDatabaseMissing('tasks', [
        'id' => $task->id,
    ]);
});

// Test validation
it('validates required fields before saving', function () {
    Livewire::test(Index::class)
        ->set('name', '')
        ->set('description', '')
        ->set('status', '')
        ->set('due_date', '')
        ->set('priority', '')
        ->set('project_id', '')
        ->call('save')
        ->assertHasErrors(['name', 'description', 'status', 'due_date', 'priority', 'project_id']);
});
