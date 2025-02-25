<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase; // Reseta o banco após cada teste (garante que não tem nada populado errado)

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_index()
    {
        Task::factory()->count(5)->create(['user_id' => $this->user->id]);

        $response = $this->get('/tasks');
        $response->assertStatus(200);

        $response->assertViewHas('tasks');
        $response->assertViewHas('totalTasks');
        $response->assertViewHas('totalCompleted');
    }

    public function test_store()
    {
        $taskData = ['task' => 'Nova tarefa'];

        $response = $this->post('/tasks', $taskData);

        $this->assertDatabaseHas('tasks', [
            'task' => 'Nova tarefa',
            'completed' => false,
            'user_id' => $this->user->id,
        ]);

        $response->assertRedirect('/tasks');
    }

    public function test_destroy()
    {
        $task = Task::factory()->create(['user_id' => $this->user->id]);

        $response = $this->delete('/tasks/' . $task->id);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);

        $response->assertRedirect('/tasks');
    }

    public function test_update()
    {
        $task = Task::factory()->create([
            'completed' => false,
            'user_id' => $this->user->id,
        ]);

        $response = $this->put('/tasks/' . $task->id);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'completed' => true,
        ]);

        $response->assertRedirect('/tasks');
    }

    public function test_store_validation_max_length()
    {
        $longString = str_repeat('a', 256);

        $response = $this->post('/tasks', ['task' => $longString]);

        $response->assertSessionHasErrors(['task']);
        $this->assertDatabaseCount('tasks', 0);
    }

    public function test_store_validation_empty_field()
    {
        $response = $this->post('/tasks', ['task' => null]);

        $response->assertSessionHasErrors(['task']);
        $this->assertDatabaseCount('tasks', 0);
    }
}
