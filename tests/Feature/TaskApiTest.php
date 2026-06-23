<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_can_create_task(): void
    {
        $data = [
            'title' => 'Test Task',
            'description' => 'Test Description',
            'due_date' => now()->addDay()->toIso8601String(),
            'priority' => 'высокий',
            'category' => 'Работа',
            'status' => 'не выполнена'
        ];

        $response = $this->postJson('/api/tasks', $data);

        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'message']);

        $this->assertDatabaseHas('tasks', ['title' => 'Test Task']);
    }

    public function test_can_list_tasks(): void
    {
        Task::factory()->count(15)->create();

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200)
            ->assertJsonCount(10, 'data') // пагинация по 10
            ->assertJsonStructure(['data', 'links', 'total', 'current_page']);
    }

    public function test_can_search_tasks(): void
    {
        Task::factory()->create(['title' => 'Unique Task Name']);
        Task::factory()->count(5)->create();

        $response = $this->getJson('/api/tasks?search=Unique');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    public function test_can_get_single_task(): void
    {
        $task = Task::factory()->create();

        $response = $this->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJson(['id' => $task->id]);
    }

    public function test_can_update_task(): void
    {
        $task = Task::factory()->create();

        $response = $this->putJson("/api/tasks/{$task->id}", [
            'title' => 'Updated Title',
            'status' => 'выполнена'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Updated Title',
            'status' => 'выполнена'
        ]);
    }

    public function test_can_delete_task(): void
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_validation_errors(): void
    {
        $response = $this->postJson('/api/tasks', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title']);
    }
}
