<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_task()
    {
        $data = [
            'title' => 'New Task',
            'description' => 'Task description',
            'due_date' => now()->addDays(5)->format('Y-m-d'),
        ];

        $this->postJson('/api/tasks', $data)
            ->assertStatus(201)
            ->assertJson(['title' => 'New Task']);
    }

    /** @test */
    public function it_updates_a_task()
    {
        $task = Task::factory()->create([
            'title' => 'Old Task',
        ]);

        $data = [
            'title' => 'New Task',
        ];

        $this->putJson("/api/tasks/{$task->id}", $data)
            ->assertStatus(200)
            ->assertJson(['title' => 'New Task']);
    }

    /** @test */
    public function it_toggles_task_completion_status()
    {
        $task = Task::factory()->create([
            'title' => 'Sample Task',
            'is_completed' => false,
        ]);

        $this->patchJson("/api/tasks/{$task->id}/toggle-completion")
            ->assertStatus(200)
            ->assertJson(['is_completed' => true]);

        $task->refresh();
        $this->assertTrue($task->is_completed);


        $this->patchJson("/api/tasks/{$task->id}/toggle-completion")
            ->assertStatus(200)
            ->assertJson(['is_completed' => false]);

        $task->refresh();
        $this->assertFalse($task->is_completed);
    }
}
