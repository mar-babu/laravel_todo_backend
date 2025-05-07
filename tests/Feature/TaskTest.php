<?php

namespace Tests\Feature;

use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = Sanctum::actingAs(User::factory()->create());
    }

    /** @test */
    public function authenticated_user_can_create_task_with_required_fields()
    {
        $response = $this->postJson('/api/tasks', [
            'name' => 'Test Task',
            'description' => 'Test Description',
            'status' => TaskStatus::PENDING->value
        ]);

        $response->assertCreated()
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('tasks', [
            'name' => 'Test Task',
            'description' => 'Test Description',
            'status' => TaskStatus::PENDING->value
        ]);
    }

    /** @test */
    public function task_creation_requires_name_and_description()
    {
        $response = $this->postJson('/api/tasks', [
            'status' => TaskStatus::PENDING->value
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'description']);
    }

    /** @test */
    public function user_can_view_their_task()
    {
        $task = Task::factory()->create(['user_id' => $this->user->id]);

        $response = $this->getJson("/api/tasks/{$task->id}");

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'description',
                    'status'
                ]
            ]);
    }

    /** @test */
    public function user_cannot_view_another_users_task()
    {
        $otherUser = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->getJson("/api/tasks/{$task->id}");

        $response->assertNotFound();
    }

    /** @test */
    public function user_can_update_their_task()
    {
        $task = Task::factory()->create(['user_id' => $this->user->id]);

        $response = $this->putJson("/api/tasks/{$task->id}", [
            'name' => 'Updated Task',
            'description' => 'Updated Description',
            'status' => TaskStatus::COMPLETED->value
        ]);

        $response->assertStatus(201)
        ->assertJson(['success' => true]);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'name' => 'Updated Task',
            'description' => 'Updated Description',
            'status' => TaskStatus::COMPLETED->value
        ]);
    }

    /** @test */
    public function user_can_update_task_status()
    {
        $task = Task::factory()->create([
            'user_id' => $this->user->id,
            'status' => TaskStatus::PENDING
        ]);

        $response = $this->putJson("/api/tasks/{$task->id}/status", [
            'status' => TaskStatus::COMPLETED->value
        ]);

        $response->assertOk()
            ->assertJson(['success' => true]);

        $this->assertEquals(TaskStatus::COMPLETED, $task->fresh()->status);
    }

    /** @test */
    public function user_can_delete_their_task()
    {
        $task = Task::factory()->create(['user_id' => $this->user->id]);

        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertOk()
            ->assertJson(['success' => true]);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

}
