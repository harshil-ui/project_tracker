<?php

use App\Models\Project;
use App\Models\User;
use App\Livewire\Pages\Project\Index;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

// Test rendering the component
it('renders the project index component', function () {
    Livewire::test(Index::class)
        ->assertStatus(200)
        ->assertSee('Projects'); // assuming your view has "Projects" text
});

// Test creating a project
it('can create a new project', function () {
    Livewire::test(Index::class)
        ->set('title', 'Test Project')
        ->set('description', 'Test Description')
        ->call('save')
        ->assertRedirect(route('projects.index'));

    $this->assertDatabaseHas('projects', [
        'title' => 'Test Project',
        'description' => 'Test Description',
    ]);
});

// Test editing a project
it('can edit an existing project', function () {
    $project = Project::factory()->create([
        'title' => 'Old Title',
        'description' => 'Old Description',
    ]);

    Livewire::test(Index::class)
        ->call('edit', $project->id)
        ->set('title', 'New Title')
        ->set('description', 'New Description')
        ->call('save')
        ->assertRedirect(route('projects.index'));

    $this->assertDatabaseHas('projects', [
        'id' => $project->id,
        'title' => 'New Title',
        'description' => 'New Description',
    ]);
});

// Test deleting a project without tasks
it('can delete a project without tasks', function () {
    $project = Project::factory()->create();

    Livewire::test(Index::class)
        ->call('delete', $project->id)
        ->assertRedirect(route('projects.index'));

    $this->assertDatabaseMissing('projects', [
        'id' => $project->id,
    ]);
});

// Test validation
it('validates title and description before saving', function () {
    Livewire::test(Index::class)
        ->set('title', '')
        ->set('description', '')
        ->call('save')
        ->assertHasErrors(['title', 'description']);
});
