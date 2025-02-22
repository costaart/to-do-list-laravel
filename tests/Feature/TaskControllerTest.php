<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase; //reseta o banco

    public function test_index()
    {
        Task::factory()->count(5)->create();

        $response = $this->get('/');
        $response->assertStatus(200);

        $response->assertViewHas('tasks');
        $response->assertViewHas('totalTasks');
        $response->assertViewHas('totalCompleted');
    }

    public function test_store()
    {
        $taskData = [
            'task' => 'Nova tarefa',
            'completed' => false
        ];

        $response = $this->post('/tasks', $taskData);

        $this->assertDatabaseHas('tasks', [
            'task' => 'Nova tarefa',
            'completed' => false,
        ]);

        $response->assertRedirect('/');
    }

    public function test_destroy()
    {
        $task = Task::factory()->create();

        $response = $this->delete('/tasks/' . $task->id);

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);

        $response->assertRedirect('/');
    }

    public function test_update()
    {
        $task = Task::factory()->create(['completed' => false]);

        $response = $this->put('/tasks/' . $task->id);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'completed' => true,
        ]);

        $response->assertRedirect('/');
    }

    public function test_store_validation_max_length()
    {
        $longString = str_repeat('a', 256); 

        $taskData = [
            'task' => $longString,
            'completed' => false
        ];

        $response = $this->post('/tasks', $taskData);

        $response->assertSessionHasErrors(['task']);

        $errorMessage = session('errors')->first('task');
        $this->assertEquals('The task field must not be greater than 255 characters.', $errorMessage);

        $this->assertDatabaseCount('tasks', 0);
    }

    public function test_store_validation_empty_field()
    {
        $emptyString = null;

        $taskData = [
            'task' => $emptyString,
            'completed' => false
        ];

        $response = $this->post('/tasks', $taskData);

        $response->assertSessionHasErrors(['task']);

        $errorMessage = session('errors')->first('task');
        $this->assertEquals('The task field is required.', $errorMessage);

        $this->assertDatabaseCount('tasks', 0);
    }
}
